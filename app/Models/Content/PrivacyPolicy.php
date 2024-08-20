<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'update_date', 'text'];

    protected $casts = ['update_date' => 'date'];
}
