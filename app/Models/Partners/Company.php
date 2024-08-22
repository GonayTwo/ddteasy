<?php

namespace App\Models\Partners;

use App\Enums\CompanyStatus;
use App\Models\Address;
use App\Models\Orders\Order;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Company extends Model implements HasAvatar, HasCurrentTenantLabel, HasName
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'corporate_name',
        'fantasy_name',
        'cnpj',
        'social_contract',
        'sanitary_license',
        'logo',
        'status',
        'slug',
        'bank',
        'agency',
        'checking_account',
        'work_days',
    ];

    protected $casts = [
        'status' => CompanyStatus::class,
        'work_days' => 'array',
    ];

    protected $attributes = [
        'work_days' => '["1","2","3","4","5","6","7"]',
    ];

    /**
     * Return the partners that belgons to this Company
     */
    public function partners(): BelongsToMany
    {
        return $this->belongsToMany(Partner::class)->using(CompanyPartner::class);
    }

    /**
     * Return the Address of the Company
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Return all the Order that this Company did
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getFilamentName(): string
    {
        return $this->corporate_name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Bem vindo(a),';
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function companyServices(): HasMany
    {
        return $this->hasMany(CompanyService::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }
}
