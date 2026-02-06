<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->input('quantity', 1);
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId,
                'quantity' => $request->input('quantity', 1),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan ke keranjang',
            'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity')
        ]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });

        return response()->json([
            'success' => true,
            'subtotal' => $cartItem->quantity * $cartItem->book->price,
            'total' => $total
        ]);
    }

    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang'
        ]);
    }

    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    public function items()
    {
        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });

        return response()->json([
            'items' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'book_id' => $item->book->id,
                    'title' => $item->book->title,
                    'price' => $item->book->price,
                    'price_formatted' => 'Rp ' . number_format($item->book->price, 0, ',', '.'),
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->book->price,
                    'subtotal_formatted' => 'Rp ' . number_format($item->quantity * $item->book->price, 0, ',', '.'),
                    'image' => $item->book->image ? asset('storage/' . $item->book->image) : asset('images/book-placeholder.png'),
                ];
            }),
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            'count' => $cartItems->sum('quantity'),
        ]);
    }
}
