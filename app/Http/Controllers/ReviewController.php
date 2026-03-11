<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     * Only verified purchasers (order status: delivered or paid) may review.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title'  => 'nullable|string|max:100',
            'body'   => 'nullable|string|max:2000',
        ]);

        $user = Auth::user();

        // Prevent duplicate review
        if (Review::where('book_id', $book->id)->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        // Check verified purchase
        $isPurchased = Order::where('user_id', $user->id)
            ->whereIn('status', ['delivered', 'paid', 'processing', 'shipped'])
            ->whereHas('items', fn($q) => $q->where('book_id', $book->id))
            ->exists();

        Review::create([
            'book_id'              => $book->id,
            'user_id'              => $user->id,
            'rating'               => $request->rating,
            'title'                => $request->title,
            'body'                 => $request->body,
            'is_verified_purchase' => $isPurchased,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim. Terima kasih!');
    }

    /**
     * Delete own review.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
