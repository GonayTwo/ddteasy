<?php

namespace App\Models\Partners;

use App\Enums\PartnerRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['cpf', 'phone', 'consent', 'role', 'contact_methods'];

    protected $casts = [
        'role' => PartnerRoles::class,
        'contact_methods' => 'array',
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->using(CompanyPartner::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn (): string => "{$this->user->first_name} {$this->user->last_name}");
    }
}
