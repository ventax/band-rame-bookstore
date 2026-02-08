<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'shipping_cost',
        'discount_amount',
        'grand_total',
        'status',
        'payment_method',
        'payment_status',
        'payment_proof',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_postal_code',
        'notes',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    // Payment status constants
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_EXPIRED = 'expired';

    // Payment method constants
    const PAYMENT_TRANSFER = 'transfer_bank';
    const PAYMENT_COD = 'cod';
    const PAYMENT_EWALLET = 'e_wallet';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', now()->toDateString())
            ->latest()
            ->first();

        $number = $lastOrder ? (int)substr($lastOrder->order_number, -4) + 1 : 1;
        $number = str_pad($number, 4, '0', STR_PAD_LEFT);

        return "ORD-{$date}-{$number}";
    }

    // Status badge colors
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_PAID => 'bg-blue-100 text-blue-800',
            self::STATUS_PROCESSING => 'bg-purple-100 text-purple-800',
            self::STATUS_SHIPPED => 'bg-indigo-100 text-indigo-800',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Payment status badge colors
    public function getPaymentBadgeAttribute()
    {
        return match ($this->payment_status) {
            self::PAYMENT_PAID => 'bg-green-100 text-green-800',
            self::PAYMENT_UNPAID => 'bg-yellow-100 text-yellow-800',
            self::PAYMENT_FAILED => 'bg-red-100 text-red-800',
            self::PAYMENT_EXPIRED => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Status text in Indonesian
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Sudah Dibayar',
            self::STATUS_PROCESSING => 'Sedang Diproses',
            self::STATUS_SHIPPED => 'Sedang Dikirim',
            self::STATUS_DELIVERED => 'Sudah Diterima',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    // Payment method text
    public function getPaymentMethodTextAttribute()
    {
        return match ($this->payment_method) {
            self::PAYMENT_TRANSFER => 'Transfer Bank',
            self::PAYMENT_COD => 'Cash on Delivery',
            self::PAYMENT_EWALLET => 'E-Wallet',
            default => '-',
        };
    }

    // Check if order can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PAID]);
    }

    // Check if order can upload payment proof
    public function canUploadPaymentProof()
    {
        return $this->payment_method === self::PAYMENT_TRANSFER
            && $this->payment_status === self::PAYMENT_UNPAID
            && $this->status === self::STATUS_PENDING;
    }
}
