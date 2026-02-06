<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

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

        return view('books.show', compact('book', 'relatedBooks'));
    }

    public function quickView(Book $book)
    {
        $book->load('category');

        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = auth()->user()->wishlists()->where('book_id', $book->id)->exists();
        }

        return response()->json([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'price' => number_format($book->price, 0, ',', '.'),
            'price_raw' => $book->price,
            'stock' => $book->stock,
            'description' => $book->description,
            'category' => $book->category->name,
            'image' => $book->image ? asset('storage/' . $book->image) : asset('images/book-placeholder.png'),
            'slug' => $book->slug,
            'in_wishlist' => $inWishlist,
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
            ->get(['id', 'title', 'author', 'price', 'image', 'slug']);

        return response()->json($books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'price' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                'image' => $book->image ? asset('storage/' . $book->image) : asset('images/book-placeholder.png'),
                'slug' => $book->slug,
            ];
        }));
    }
}
