<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    Mail::raw('Test email berhasil dari ATiga BookStore! Konfigurasi SMTP Gmail sudah benar.', function ($m) {
        $m->to('atigabooks@gmail.com')->subject('Test Konfigurasi Email - ATiga BookStore');
    });
    echo "✓ Email terkirim berhasil!\n";
} catch (Exception $e) {
    echo "✗ Gagal: " . $e->getMessage() . "\n";
}
