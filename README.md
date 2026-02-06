# 📚 BookStore - Toko Buku Online

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Tailwind-3-blue" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Alpine.js-3-green" alt="Alpine.js">
  <img src="https://img.shields.io/badge/PHP-8.2-purple" alt="PHP 8.2">
</p>

Website toko buku online yang lengkap dengan tampilan modern, UI/UX interaktif, dan sistem pembayaran terintegrasi.

## ✨ Fitur Utama

### 🛍️ Customer Features

- ✅ **Homepage** dengan featured books dan latest arrivals
- ✅ **Katalog Buku** dengan search, filter kategori, dan sorting
- ✅ **Detail Buku** lengkap dengan related books
- ✅ **Shopping Cart** interaktif dengan AJAX
- ✅ **Checkout Process** dengan form validasi lengkap
- ✅ **Order Management** untuk tracking pesanan
- ✅ **Payment System** dengan multiple payment methods
- ✅ **User Authentication** (Register, Login, Logout)

### 🎨 UI/UX Features

- ✅ Responsive Design (Mobile, Tablet, Desktop)
- ✅ Modern & Clean Interface dengan Tailwind CSS
- ✅ Interactive Elements dengan Alpine.js
- ✅ Real-time Cart Updates
- ✅ Smooth Animations & Transitions

### 💳 Payment Methods

- Bank Transfer (BCA, Mandiri, BNI, BRI)
- Credit/Debit Card (Visa, Mastercard, JCB)
- E-Wallet (GoPay, OVO, Dana, LinkAja)

## 🚀 Quick Start

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Installation

1. **Clone & Install Dependencies**

```bash
cd c:\laragon\www\web-bookstore
composer install
npm install
```

2. **Environment Setup**

```bash
cp .env.example .env
php artisan key:generate
```

3. **Database Setup**

```bash
# Edit .env file untuk konfigurasi database
# DB_DATABASE=bookstore_db

# Run migration & seeding
php artisan migrate:fresh --seed
```

4. **Install Authentication**

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
```

5. **Build Assets & Run Server**

```bash
npm run build
php artisan serve
```

6. **Access Application**

```
URL: http://localhost:8000
Email: test@example.com
Password: password
```

📖 **Dokumentasi Lengkap**: Lihat [SETUP_GUIDE.md](SETUP_GUIDE.md) dan [QUICK_START.md](QUICK_START.md)

## 📁 Project Structure

```
web-bookstore/
├── app/
│   ├── Http/Controllers/
│   │   ├── BookController.php      # Catalog & detail buku
│   │   ├── CartController.php      # Shopping cart
│   │   ├── OrderController.php     # Order management
│   │   └── PaymentController.php   # Payment processing
│   └── Models/
│       ├── Book.php
│       ├── Category.php
│       ├── Cart.php
│       ├── Order.php
│       ├── OrderItem.php
│       └── Payment.php
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/
│       ├── CategorySeeder.php      # 8 categories
│       └── BookSeeder.php          # 15+ sample books
├── resources/
│   ├── css/
│   │   └── app.css                 # Tailwind CSS
│   ├── js/
│   │   └── app.js                  # Alpine.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php       # Main layout
│       ├── home.blade.php          # Homepage
│       ├── books/                  # Book views
│       ├── cart/                   # Cart views
│       ├── checkout/               # Checkout views
│       ├── orders/                 # Order views
│       └── payment/                # Payment views
└── routes/
    └── web.php                     # All routes
```

## 🎯 Fitur yang Sudah Diimplementasi

- [x] Database Schema & Migrations (6 tables)
- [x] Models dengan Relationships
- [x] Controllers untuk semua fitur
- [x] Responsive UI dengan Tailwind CSS
- [x] Interactive components dengan Alpine.js
- [x] Homepage dengan featured books
- [x] Katalog buku (search, filter, sort)
- [x] Detail buku dengan related books
- [x] Shopping cart (add, update, remove)
- [x] Checkout process
- [x] Order management & history
- [x] Payment page dengan multi-method
- [x] Seeders untuk data sample

## 🔮 Fitur yang Bisa Ditambahkan

- [ ] Admin Panel untuk CRUD management
- [ ] Integrasi Payment Gateway aktif (Midtrans/Xendit)
- [ ] Email Notifications
- [ ] Review & Rating system
- [ ] Wishlist feature
- [ ] Advanced filters (price range, year, publisher)
- [ ] Voucher & Discount codes
- [ ] Stock alert notifications
- [ ] Order tracking
- [ ] Multi-language support

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS 3, Alpine.js 3
- **Database**: MySQL
- **Icons**: Font Awesome 6
- **Authentication**: Laravel Breeze

## 📊 Database Schema

### Tables

- `users` - User accounts
- `categories` - Book categories
- `books` - Book catalog
- `cart` - Shopping cart items
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment transactions

## 🎨 Screenshots

_(Coming soon - Add screenshots of your website)_

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 💬 Support

Jika ada pertanyaan atau butuh bantuan:

- 📧 Email: info@bookstore.com
- 📱 Phone: +62 812-3456-7890

---

Made with ❤️ using Laravel & Tailwind CSS

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
