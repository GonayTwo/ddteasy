<?php

namespace App\Models\Services;

use App\Enums\PropertyTypes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceRange extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'service_id',
        'property_type',
        'property_size',
        'min_price',
        'max_price',
    ];

    protected $casts = [
        'property_type' => PropertyTypes::class,
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
