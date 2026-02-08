<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // List all addresses
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    // Show create form
    public function create()
    {
        return view('addresses.create');
    }

    // Store new address
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'notes' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();

        // If this is set as default, unset others
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        // If this is the first address, set as default
        if (Address::where('user_id', Auth::id())->count() === 0) {
            $validated['is_default'] = true;
        }

        Address::create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Alamat berhasil ditambahkan!');
    }

    // Show edit form
    public function edit(Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('addresses.edit', compact('address'));
    }

    // Update address
    public function update(Request $request, Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'notes' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, unset others
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Alamat berhasil diupdate!');
    }

    // Delete address
    public function destroy(Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted address was default, set another as default
        if ($wasDefault) {
            $nextAddress = Address::where('user_id', Auth::id())->first();
            if ($nextAddress) {
                $nextAddress->update(['is_default' => true]);
            }
        }

        return redirect()->route('addresses.index')
            ->with('success', 'Alamat berhasil dihapus!');
    }

    // Set as default address
    public function setDefault(Address $address)
    {
        // Check ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->setAsDefault();

        return redirect()->back()
            ->with('success', 'Alamat utama berhasil diubah!');
    }
}
