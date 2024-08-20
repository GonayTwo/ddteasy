<?php

namespace App\Models\Services;

use App\Models\Partners\CompanyService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'observations', 'benefits'];

    protected $casts = ['benefits' => 'array'];

    /**
     * Return all the Plagues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plagues()
    {
        return $this->belongsToMany(Plague::class);
    }

    public function priceRanges(): HasMany
    {
        return $this->hasMany(PriceRange::class);
    }

    public function companyServices(): HasMany
    {
        return $this->hasMany(CompanyService::class);
    }
}
