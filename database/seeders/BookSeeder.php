<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Fiksi
            [
                'title' => 'Laskar Pelangi',
                'category_id' => 1,
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9789791227780',
                'description' => 'Novel tentang perjuangan anak-anak Belitung yang miskin untuk mendapatkan pendidikan.',
                'price' => 89000,
                'stock' => 50,
                'pages' => 529,
                'language' => 'Indonesian',
                'published_year' => 2005,
                'is_featured' => true,
            ],
            [
                'title' => 'Bumi Manusia',
                'category_id' => 1,
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'isbn' => '9789799731234',
                'description' => 'Novel sejarah tentang kehidupan masyarakat pribumi pada masa kolonial Belanda.',
                'price' => 95000,
                'stock' => 40,
                'pages' => 535,
                'language' => 'Indonesian',
                'published_year' => 1980,
                'is_featured' => true,
            ],
            [
                'title' => 'Perahu Kertas',
                'category_id' => 1,
                'author' => 'Dee Lestari',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9789797807832',
                'description' => 'Novel romantis tentang dua orang dengan mimpi yang berbeda.',
                'price' => 75000,
                'stock' => 35,
                'pages' => 444,
                'language' => 'Indonesian',
                'published_year' => 2009,
                'is_featured' => false,
            ],

            // Non-Fiksi
            [
                'title' => 'Sejarah Indonesia Modern',
                'category_id' => 2,
                'author' => 'M.C. Ricklefs',
                'publisher' => 'Gadjah Mada University Press',
                'isbn' => '9789794202661',
                'description' => 'Buku sejarah komprehensif tentang Indonesia dari abad ke-13 hingga modern.',
                'price' => 150000,
                'stock' => 25,
                'pages' => 783,
                'language' => 'Indonesian',
                'published_year' => 2008,
                'is_featured' => false,
            ],

            // Bisnis & Ekonomi
            [
                'title' => 'Rich Dad Poor Dad',
                'category_id' => 3,
                'author' => 'Robert T. Kiyosaki',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9789792202601',
                'description' => 'Buku tentang keuangan pribadi dan investasi yang mengubah cara pandang terhadap uang.',
                'price' => 110000,
                'stock' => 60,
                'pages' => 266,
                'language' => 'Indonesian',
                'published_year' => 1997,
                'is_featured' => true,
            ],
            [
                'title' => 'The Lean Startup',
                'category_id' => 3,
                'author' => 'Eric Ries',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9786021186121',
                'description' => 'Metode baru untuk mengembangkan bisnis dan produk dengan lebih efisien.',
                'price' => 125000,
                'stock' => 45,
                'pages' => 336,
                'language' => 'Indonesian',
                'published_year' => 2011,
                'is_featured' => true,
            ],

            // Teknologi & Komputer
            [
                'title' => 'Clean Code',
                'category_id' => 4,
                'author' => 'Robert C. Martin',
                'publisher' => 'Pearson',
                'isbn' => '9780132350884',
                'description' => 'Panduan untuk menulis kode yang bersih, mudah dibaca, dan maintainable.',
                'price' => 450000,
                'stock' => 30,
                'pages' => 464,
                'language' => 'English',
                'published_year' => 2008,
                'is_featured' => true,
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'category_id' => 4,
                'author' => 'Douglas Crockford',
                'publisher' => "O'Reilly Media",
                'isbn' => '9780596517748',
                'description' => 'Panduan untuk memahami dan menggunakan bagian terbaik dari JavaScript.',
                'price' => 350000,
                'stock' => 25,
                'pages' => 176,
                'language' => 'English',
                'published_year' => 2008,
                'is_featured' => false,
            ],
            [
                'title' => 'Python Crash Course',
                'category_id' => 4,
                'author' => 'Eric Matthes',
                'publisher' => 'No Starch Press',
                'isbn' => '9781593279288',
                'description' => 'Panduan praktis untuk belajar Python programming dengan cepat.',
                'price' => 400000,
                'stock' => 35,
                'pages' => 560,
                'language' => 'English',
                'published_year' => 2019,
                'is_featured' => true,
            ],

            // Pengembangan Diri
            [
                'title' => 'Atomic Habits',
                'category_id' => 5,
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9786020633176',
                'description' => 'Cara mudah dan terbukti untuk membentuk kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'price' => 95000,
                'stock' => 80,
                'pages' => 352,
                'language' => 'Indonesian',
                'published_year' => 2018,
                'is_featured' => true,
            ],
            [
                'title' => 'The 7 Habits of Highly Effective People',
                'category_id' => 5,
                'author' => 'Stephen R. Covey',
                'publisher' => 'Binarupa Aksara',
                'isbn' => '9789795929994',
                'description' => '7 kebiasaan yang akan mengubah hidup Anda menjadi lebih efektif.',
                'price' => 135000,
                'stock' => 55,
                'pages' => 464,
                'language' => 'Indonesian',
                'published_year' => 1989,
                'is_featured' => true,
            ],

            // Pendidikan
            [
                'title' => 'Matematika SMA Kelas X',
                'category_id' => 6,
                'author' => 'Tim Penulis',
                'publisher' => 'Erlangga',
                'isbn' => '9786024863234',
                'description' => 'Buku pelajaran matematika untuk SMA kelas X sesuai kurikulum.',
                'price' => 85000,
                'stock' => 100,
                'pages' => 384,
                'language' => 'Indonesian',
                'published_year' => 2021,
                'is_featured' => false,
            ],

            // Agama & Spiritualitas
            [
                'title' => 'Terjemah Al-Quran',
                'category_id' => 7,
                'author' => 'Kementerian Agama RI',
                'publisher' => 'Departemen Agama',
                'isbn' => '9789790000000',
                'description' => 'Terjemahan Al-Quran Bahasa Indonesia lengkap dengan tajwid.',
                'price' => 120000,
                'stock' => 70,
                'pages' => 604,
                'language' => 'Indonesian',
                'published_year' => 2020,
                'is_featured' => false,
            ],

            // Anak-anak
            [
                'title' => 'Harry Potter dan Batu Bertuah',
                'category_id' => 8,
                'author' => 'J.K. Rowling',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9789792202069',
                'description' => 'Petualangan Harry Potter di Hogwarts dimulai.',
                'price' => 98000,
                'stock' => 65,
                'pages' => 352,
                'language' => 'Indonesian',
                'published_year' => 1997,
                'is_featured' => true,
            ],
            [
                'title' => 'Dongeng Sebelum Tidur',
                'category_id' => 8,
                'author' => 'Kak Rico',
                'publisher' => 'BIP',
                'isbn' => '9786023851522',
                'description' => 'Kumpulan dongeng untuk anak-anak dengan nilai moral yang baik.',
                'price' => 55000,
                'stock' => 90,
                'pages' => 128,
                'language' => 'Indonesian',
                'published_year' => 2019,
                'is_featured' => false,
            ],
        ];

        foreach ($books as $book) {
            Book::create([
                'title' => $book['title'],
                'slug' => Str::slug($book['title']),
                'category_id' => $book['category_id'],
                'author' => $book['author'],
                'publisher' => $book['publisher'],
                'isbn' => $book['isbn'],
                'description' => $book['description'],
                'price' => $book['price'],
                'stock' => $book['stock'],
                'pages' => $book['pages'],
                'language' => $book['language'],
                'published_year' => $book['published_year'],
                'is_featured' => $book['is_featured'],
            ]);
        }
    }
}
