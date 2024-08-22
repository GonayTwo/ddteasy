<?php

namespace App\Models\Partners;

use App\Models\Address;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['company_id', 'name', 'email', 'image', 'cpf', 'active', 'phones'];

    protected $casts = ['phones' => 'array'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
