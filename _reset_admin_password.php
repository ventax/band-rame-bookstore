<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Ganti email dan password baru di sini
$email       = 'admin@ATigaBookStore.com';
$newPassword = 'admin123';

$user = App\Models\User::where('email', $email)->first();
if ($user) {
    $user->password = bcrypt($newPassword);
    $user->save();
    echo "Password untuk {$email} berhasil diubah ke: {$newPassword}\n";
} else {
    echo "User tidak ditemukan.\n";
}
