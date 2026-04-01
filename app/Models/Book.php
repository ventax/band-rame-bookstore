<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'author',
        'publisher',
        'isbn',
        'description',
        'price',
        'discount',
        'stock',
        'cover_image',
        'gallery_images',
        'pdf_file',
        'pages',
        'language',
        'published_year',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'integer',
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
    ];

    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount > 0) {
            return $this->price * (1 - $this->discount / 100);
        }
        return (float) $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function averageRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }
}
