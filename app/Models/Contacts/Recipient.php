<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Recipient extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['email', 'forms'];

    protected $casts = [
        'forms' => 'array',
    ];
}
