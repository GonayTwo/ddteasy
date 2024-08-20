<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContract extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'update_date', 'text'];

    protected $casts = ['update_date' => 'date'];
}
