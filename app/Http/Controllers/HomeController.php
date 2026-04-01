<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::with('category')
            ->where('is_featured', true)
            ->take(4)
            ->get();

        $categories = Category::withCount('books')
            ->orderByDesc('books_count')
            ->take(8)
            ->get();

        $totalBooks    = Book::count();
        $totalCategories = Category::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $storeRating = (float) Review::avg('rating');
        $storeRating = $storeRating > 0 ? round($storeRating, 1) : 0.0;

        return view('home', compact(
            'featuredBooks',
            'categories',
            'totalBooks',
            'totalCategories',
            'totalCustomers',
            'storeRating'
        ));
    }
}
