<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class AdminSettingController extends Controller
{
    public function logo()
    {
        $logoPath    = Storage::disk('public')->exists('logo/logo.png')
            ? asset('storage/logo/logo.png') : null;
        $faviconPath = Storage::disk('public')->exists('logo/favicon.png')
            ? asset('storage/logo/favicon.png') : null;
        $siteName    = config('app.name');

        return view('admin.settings.logo', compact('logoPath', 'faviconPath', 'siteName'));
    }

    /* ─── Logo ─── */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ], [
            'logo.required' => 'Pilih file logo terlebih dahulu.',
            'logo.image'    => 'File harus berupa gambar.',
            'logo.mimes'    => 'Format logo harus PNG, JPG, JPEG, SVG, atau WEBP.',
            'logo.max'      => 'Ukuran logo maksimal 2 MB.',
        ]);

        if (Storage::disk('public')->exists('logo/logo.png')) {
            Storage::disk('public')->delete('logo/logo.png');
        }
        $request->file('logo')->storeAs('logo', 'logo.png', 'public');

        return redirect()->route('admin.settings.logo')->with('success', 'Logo berhasil diperbarui!');
    }

    public function deleteLogo()
    {
        if (Storage::disk('public')->exists('logo/logo.png')) {
            Storage::disk('public')->delete('logo/logo.png');
            return redirect()->route('admin.settings.logo')->with('success', 'Logo berhasil dihapus.');
        }
        return redirect()->route('admin.settings.logo')->with('error', 'Tidak ada logo yang ditemukan.');
    }

    /* ─── Favicon ─── */
    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => ['required', 'image', 'mimes:png,jpg,jpeg,ico,webp', 'max:1024'],
        ], [
            'favicon.required' => 'Pilih file favicon terlebih dahulu.',
            'favicon.image'    => 'File harus berupa gambar.',
            'favicon.mimes'    => 'Format favicon harus PNG, ICO, JPEG, atau WEBP.',
            'favicon.max'      => 'Ukuran favicon maksimal 1 MB.',
        ]);

        if (Storage::disk('public')->exists('logo/favicon.png')) {
            Storage::disk('public')->delete('logo/favicon.png');
        }
        $request->file('favicon')->storeAs('logo', 'favicon.png', 'public');

        return redirect()->route('admin.settings.logo')->with('success', 'Favicon berhasil diperbarui!');
    }

    public function deleteFavicon()
    {
        if (Storage::disk('public')->exists('logo/favicon.png')) {
            Storage::disk('public')->delete('logo/favicon.png');
            return redirect()->route('admin.settings.logo')->with('success', 'Favicon berhasil dihapus.');
        }
        return redirect()->route('admin.settings.logo')->with('error', 'Tidak ada favicon yang ditemukan.');
    }

    /* ─── Site Name ─── */
    public function updateSiteName(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:60'],
        ], [
            'site_name.required' => 'Nama website tidak boleh kosong.',
            'site_name.max'      => 'Nama website maksimal 60 karakter.',
        ]);

        $newName = trim($request->site_name);
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        // Replace APP_NAME in .env (handles quoted and unquoted values)
        $envContent = preg_replace(
            '/^APP_NAME=.*/m',
            'APP_NAME=' . (str_contains($newName, ' ') ? '"' . $newName . '"' : $newName),
            $envContent
        );
        file_put_contents($envPath, $envContent);

        // Clear config cache so new name takes effect immediately
        \Illuminate\Support\Facades\Artisan::call('config:clear');

        return redirect()->route('admin.settings.logo')->with('success', 'Nama website berhasil diperbarui menjadi "' . $newName . '"!');
    }

    /* ─── Content / CMS ─── */
    public function content(string $group = 'hero')
    {
        $allowedGroups = ['hero', 'features', 'cta', 'store', 'social'];
        if (!in_array($group, $allowedGroups)) {
            $group = 'hero';
        }

        $settings = SiteSetting::where('group', $group)->orderBy('id')->get();
        $activeGroup = $group;

        return view('admin.settings.content', compact('settings', 'activeGroup'));
    }

    public function updateContent(Request $request, string $group)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Only update if key belongs to this group
            SiteSetting::where('key', $key)->where('group', $group)->update(['value' => $value]);
        }

        Cache::forget('site_settings');

        return redirect()
            ->route('admin.settings.content', $group)
            ->with('success', 'Konten berhasil diperbarui!');
    }
}
