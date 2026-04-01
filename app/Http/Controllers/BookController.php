<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
        }

        $books = $query->paginate(12);
        $categories = Category::withCount('books')->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function show($slug)
    {
        $book = Book::with('category')->where('slug', $slug)->firstOrFail();
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        // Reviews
        $reviews       = $book->reviews()->with('user')->paginate(8);
        $avgRating     = $book->averageRating();
        $reviewsCount  = $book->reviewsCount();
        $starBreakdown = Review::starBreakdown($book->id);

        // Current user's state
        $userReview     = null;
        $userCanReview  = false;
        if (Auth::check()) {
            $userReview    = Review::where('book_id', $book->id)->where('user_id', Auth::id())->first();
            $userCanReview = !$userReview && Order::where('user_id', Auth::id())
                ->whereIn('status', ['delivered', 'paid', 'processing', 'shipped'])
                ->whereHas('items', fn($q) => $q->where('book_id', $book->id))
                ->exists();
        }

        return view('books.show', compact(
            'book',
            'relatedBooks',
            'reviews',
            'avgRating',
            'reviewsCount',
            'starBreakdown',
            'userReview',
            'userCanReview'
        ));
    }

    public function quickView(Book $book)
    {
        $book->load('category');

        $imageUrls = collect([$book->cover_image])
            ->merge($book->gallery_images ?? [])
            ->filter()
            ->unique()
            ->map(fn($path) => asset('storage/' . $path))
            ->values()
            ->all();

        $primaryImage = $imageUrls[0] ?? asset('images/book-placeholder.png');

        $inWishlist = false;
        if (Auth::check()) {
            $inWishlist = Wishlist::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->exists();
        }

        return response()->json([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'price' => number_format($book->discounted_price, 0, ',', '.'),
            'price_raw' => $book->discounted_price,
            'original_price' => number_format($book->price, 0, ',', '.'),
            'discount' => $book->discount,
            'stock' => $book->stock,
            'description' => $book->description,
            'category' => $book->category->name,
            'image' => $primaryImage,
            'images' => $imageUrls,
            'slug' => $book->slug,
            'in_wishlist' => $inWishlist,
            'has_pdf' => !empty($book->pdf_file),
        ]);
    }

    public function viewPdf(Book $book)
    {
        if (!$book->pdf_file) {
            abort(404, 'PDF tidak tersedia untuk buku ini.');
        }

        return view('books.pdf', compact('book'));
    }

    public function pdfFile(Book $book)
    {
        if (!$book->pdf_file || !Storage::disk('public')->exists($book->pdf_file)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($book->pdf_file);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'public, max-age=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $books = Book::where('title', 'like', '%' . $query . '%')
            ->orWhere('author', 'like', '%' . $query . '%')
            ->limit(5)
            ->get(['id', 'title', 'author', 'price', 'cover_image', 'slug']);

        return response()->json($books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'price' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                'image' => $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/book-placeholder.png'),
                'slug' => $book->slug,
            ];
        }));
    }
}
