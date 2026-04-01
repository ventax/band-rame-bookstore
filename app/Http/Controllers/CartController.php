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
            return $item->quantity * $item->book->discounted_price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);
        $requestedQty = max((int) $request->input('quantity', 1), 1);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->first();

        $currentQty = $cartItem ? (int) $cartItem->quantity : 0;
        $targetQty = $currentQty + $requestedQty;

        if ((int) $book->stock < 1) {
            $message = 'Stok buku habis.';

            if ($request->expectsJson() || $request->ajax() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        if ($targetQty > (int) $book->stock) {
            $message = 'Jumlah melebihi stok tersedia. Sisa stok: ' . (int) $book->stock . '.';

            if ($request->expectsJson() || $request->ajax() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        if ($cartItem) {
            $cartItem->quantity = $targetQty;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId,
                'quantity' => $requestedQty,
            ]);
        }

        $payload = [
            'success' => true,
            'message' => 'Buku berhasil ditambahkan ke keranjang',
            'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity')
        ];

        if ($request->expectsJson() || $request->ajax() || $request->isJson()) {
            return response()->json($payload);
        }

        return redirect()->back()->with('success', $payload['message']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $newQty = (int) $request->quantity;
        $bookStock = (int) $cartItem->book->stock;

        if ($bookStock < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok buku habis.',
            ], 422);
        }

        if ($newQty > $bookStock) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok tersedia. Sisa stok: ' . $bookStock . '.',
            ], 422);
        }

        $cartItem->quantity = $newQty;
        $cartItem->save();

        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->discounted_price;
        });

        return response()->json([
            'success' => true,
            'subtotal' => $cartItem->quantity * $cartItem->book->discounted_price,
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
            return $item->quantity * $item->book->discounted_price;
        });

        return response()->json([
            'items' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'book_id' => $item->book->id,
                    'title' => $item->book->title,
                    'price' => $item->book->discounted_price,
                    'price_formatted' => 'Rp ' . number_format($item->book->discounted_price, 0, ',', '.'),
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->book->discounted_price,
                    'subtotal_formatted' => 'Rp ' . number_format($item->quantity * $item->book->discounted_price, 0, ',', '.'),
                    'image' => $item->book->image ? asset('storage/' . $item->book->image) : asset('images/book-placeholder.png'),
                ];
            }),
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            'count' => $cartItems->sum('quantity'),
        ]);
    }
}
