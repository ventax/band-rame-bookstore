<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('book.category')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        \Log::info('Wishlist toggle requested', [
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
        ]);

        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            \Log::info('Wishlist removed', ['book_id' => $request->book_id]);
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Buku dihapus dari wishlist'
            ]);
        } else {
            $created = Wishlist::create([
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
            ]);
            \Log::info('Wishlist added', ['wishlist_id' => $created->id]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Buku ditambahkan ke wishlist'
            ]);
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();
        return redirect()->route('wishlist.index')->with('success', 'Buku dihapus dari wishlist');
    }
}
