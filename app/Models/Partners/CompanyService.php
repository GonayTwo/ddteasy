<?php

namespace App\Models\Partners;

use App\Enums\PropertyTypes;
use App\Models\Services\Service;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyService extends Model
{
    use HasUuids;

    protected $fillable = [
        'company_id',
        'service_id',
        'property_type',
        'property_size',
        'daily_price',
    ];

    protected $casts = [
        'property_type' => PropertyTypes::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
