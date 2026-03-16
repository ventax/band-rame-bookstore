<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 401);

        $wishlists = Wishlist::query()
            ->where('user_id', $user->id)
            ->with('book.category')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 401);

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $bookId = (int) $validated['book_id'];

        Log::info('Wishlist toggle requested', [
            'user_id' => $user->id,
            'book_id' => $bookId,
        ]);

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            Log::info('Wishlist removed', ['book_id' => $bookId]);
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Buku dihapus dari wishlist'
            ]);
        } else {
            $created = Wishlist::create([
                'user_id' => $user->id,
                'book_id' => $bookId,
            ]);
            Log::info('Wishlist added', ['wishlist_id' => $created->id]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Buku ditambahkan ke wishlist'
            ]);
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 401);

        if ((int) $wishlist->user_id !== (int) $user->id) {
            abort(403);
        }

        $wishlist->delete();
        return redirect()->route('wishlist.index')->with('success', 'Buku dihapus dari wishlist');
    }

    public function count()
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 401);

        $count = Wishlist::where('user_id', $user->id)->count();
        return response()->json(['count' => $count]);
    }
}
