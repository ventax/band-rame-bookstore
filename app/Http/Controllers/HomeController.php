<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::with('category')
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $latestBooks = Book::with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredBooks', 'latestBooks'));
    }
}
