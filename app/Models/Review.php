<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'title',
        'body',
        'is_verified_purchase',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Star breakdown helper — returns array of percentage per rating (5..1) */
    public static function starBreakdown($bookId): array
    {
        $counts = static::where('book_id', $bookId)
            ->selectRaw('rating, count(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        $total = $counts->sum();
        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $counts->get($i, 0);
            $breakdown[$i] = [
                'count'   => $count,
                'percent' => $total > 0 ? round($count / $total * 100) : 0,
            ];
        }
        return $breakdown;
    }
}
