<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function logo()
    {
        $logoPath = null;
        if (Storage::disk('public')->exists('logo/logo.png')) {
            $logoPath = asset('storage/logo/logo.png');
        }

        return view('admin.settings.logo', compact('logoPath'));
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ], [
            'logo.required'  => 'Pilih file logo terlebih dahulu.',
            'logo.image'     => 'File harus berupa gambar.',
            'logo.mimes'     => 'Format logo harus PNG, JPG, JPEG, SVG, atau WEBP.',
            'logo.max'       => 'Ukuran logo maksimal 2 MB.',
        ]);

        // Delete old logo if exists
        if (Storage::disk('public')->exists('logo/logo.png')) {
            Storage::disk('public')->delete('logo/logo.png');
        }

        // Store new logo with fixed name so front-end always references the same path
        $request->file('logo')->storeAs('logo', 'logo.png', 'public');

        return redirect()->route('admin.settings.logo')->with('success', 'Logo berhasil diperbarui!');
    }

    public function deleteLogo()
    {
        if (Storage::disk('public')->exists('logo/logo.png')) {
            Storage::disk('public')->delete('logo/logo.png');
            return redirect()->route('admin.settings.logo')->with('success', 'Logo berhasil dihapus. Website akan kembali menggunakan logo default.');
        }

        return redirect()->route('admin.settings.logo')->with('error', 'Tidak ada logo yang ditemukan.');
    }
}
