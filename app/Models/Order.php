<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'notes',
        'payment_method',
        'status',
        'subtotal',
        'delivery_fee',
        'total',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'WB';
        $date = date('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }
}
