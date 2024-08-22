<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Admin extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['phone'];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
