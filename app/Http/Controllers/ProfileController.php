<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    private function currentUser(): User
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 401);

        return $user;
    }

    public function setup()
    {
        $user = $this->currentUser();
        // Kalau profil sudah lengkap, langsung ke dashboard
        if ($user->phone && $user->birth_date && $user->gender) {
            return redirect()->route('dashboard')->with('success', 'Profil Anda sudah lengkap!');
        }
        return view('profile.setup', compact('user'));
    }

    public function storeSetup(Request $request)
    {
        $user = $this->currentUser();
        $validated = $request->validate([
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:' . now()->subYears(17)->toDateString()],
            'gender'     => ['nullable', 'in:male,female,other'],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'birth_date.before_or_equal' => 'Usia minimal yang diperbolehkan adalah 17 tahun.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);
        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '! Profil Anda berhasil disimpan. Selamat berbelanja! 🎉');
    }

    public function edit()
    {
        try {
            $user = $this->currentUser();

            $addresses = $user->addresses()->latest()->get();

            // Debug log
            Log::info('Profile Edit - User: ' . $user->name . ', Addresses: ' . $addresses->count());

            return view('profile.edit', compact('user', 'addresses'));
        } catch (\Exception $e) {
            Log::error('Profile Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $user = $this->currentUser();

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:' . now()->subYears(17)->toDateString()],
            'gender'     => ['nullable', 'in:male,female,other'],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'birth_date.before_or_equal' => 'Usia minimal yang diperbolehkan adalah 17 tahun.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $this->currentUser()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah!');
    }

    public function storeAddress(Request $request)
    {
        $user = $this->currentUser();

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'notes' => ['nullable', 'string'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        // If this address is set as default, unset other defaults
        if ($request->is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        $validated['user_id'] = $user->id;
        $validated['is_default'] = $request->boolean('is_default');

        Address::create($validated);

        return redirect()->route('profile.edit')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function updateAddress(Request $request, Address $address)
    {
        $user = $this->currentUser();

        // Ensure user owns this address
        if ((int) $address->user_id !== (int) $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'notes' => ['nullable', 'string'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        // If this address is set as default, unset other defaults
        if ($request->is_default) {
            $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $validated['is_default'] = $request->boolean('is_default');
        $address->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroyAddress(Address $address)
    {
        $user = $this->currentUser();

        // Ensure user owns this address
        if ((int) $address->user_id !== (int) $user->id) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('profile.edit')->with('success', 'Alamat berhasil dihapus!');
    }

    public function setDefaultAddress(Address $address)
    {
        $user = $this->currentUser();

        // Ensure user owns this address
        if ((int) $address->user_id !== (int) $user->id) {
            abort(403);
        }

        // Unset all defaults
        $user->addresses()->update(['is_default' => false]);

        // Set this as default
        $address->update(['is_default' => true]);

        return redirect()->route('profile.edit')->with('success', 'Alamat utama berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
