<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminBookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:5120',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:50',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['discount'] = $request->input('discount', 0);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $imageFile) {
                $galleryImages[] = $imageFile->store('books/gallery', 'public');
            }
            $validated['gallery_images'] = $galleryImages;
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:5120',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:50',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $book->id);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['discount'] = $request->input('discount', 0);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $existingGallery = is_array($book->gallery_images) ? $book->gallery_images : [];
            $newGallery = [];

            foreach ($request->file('gallery_images') as $imageFile) {
                $newGallery[] = $imageFile->store('books/gallery', 'public');
            }

            $validated['gallery_images'] = array_values(array_unique(array_merge($existingGallery, $newGallery)));
        }

        if ($request->hasFile('pdf_file')) {
            // Delete old PDF
            if ($book->pdf_file) {
                Storage::disk('public')->delete($book->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Book $book)
    {
        $this->deleteBookAssets($book);

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        $books = Book::whereIn('id', $validated['book_ids'])->get();

        if ($books->isEmpty()) {
            return redirect()->route('admin.books.index')->with('error', 'Tidak ada buku yang dipilih.');
        }

        foreach ($books as $book) {
            $this->deleteBookAssets($book);
            $book->delete();
        }

        return redirect()->route('admin.books.index')
            ->with('success', $books->count() . ' buku berhasil dihapus.');
    }

    private function deleteBookAssets(Book $book): void
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        if ($book->pdf_file) {
            Storage::disk('public')->delete($book->pdf_file);
        }

        if (!empty($book->gallery_images) && is_array($book->gallery_images)) {
            Storage::disk('public')->delete($book->gallery_images);
        }
    }

    private function generateUniqueSlug(string $title, ?int $ignoreBookId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Book::where('slug', $slug)
            ->when($ignoreBookId, fn($query) => $query->where('id', '!=', $ignoreBookId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
