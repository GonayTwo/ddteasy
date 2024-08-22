<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreRegistration extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'company', 'email', 'phone', 'contact_methods', 'finished'];

    protected $casts = ['contact_methods' => 'array'];
}
