# Midtrans Callback Checklist (CyberPanel)

## 1) Set URL callback di Midtrans Dashboard

- Notification URL: https://example.com/payment/callback
- Finish Redirect URL: https://example.com/checkout/midtrans/finish

## 2) Isi ENV production

- APP_URL=https://example.com
- MIDTRANS_SERVER_KEY=...
- MIDTRANS_CLIENT_KEY=...
- MIDTRANS_IS_PRODUCTION=true
- MIDTRANS_SANITIZE=true
- MIDTRANS_3DS=true

## 3) Validasi route di server

Jalankan:

```bash
php artisan route:list | grep -E "payment/callback|checkout/midtrans/finish"
```

Harus ada endpoint:

- POST payment/callback
- GET checkout/midtrans/finish

## 4) Validasi HTTPS

- Pastikan SSL aktif untuk domain.
- Cek URL callback bisa diakses dari internet (bukan localhost).

## 5) Uji transaksi sandbox/live

- Lakukan 1 transaksi dari frontend.
- Selesaikan pembayaran sampai status settlement.
- Pastikan data order terupdate (payment_status paid, status processing).

## 6) Cek log jika callback gagal

- Cek Laravel log: storage/logs/laravel.log
- Cek OpenLiteSpeed error log dari CyberPanel
- Pastikan firewall tidak memblokir request Midtrans

## 7) Verifikasi webhook signature (opsional tapi disarankan)

- Tambahkan verifikasi signature_key dari Midtrans payload.
- Reject request jika signature tidak valid.

## 8) Konfirmasi idempotency callback

- Callback dapat dikirim ulang oleh gateway.
- Pastikan update data payment menggunakan updateOrCreate untuk mencegah duplikasi.

## 9) Monitoring pasca go-live

- Pantau order status pending lebih dari 15 menit.
- Buat alert jika callback error berulang.
