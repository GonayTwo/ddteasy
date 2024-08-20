<?php

namespace App\Models\Orders;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusUpdate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['order_id', 'status', 'observation'];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
