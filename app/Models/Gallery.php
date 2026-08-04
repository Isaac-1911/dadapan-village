<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Gallery extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [

        'title',
        'description',
        'event_date',
        'image',
        'caption'
    ];

    protected $casts = [
        'event_date' => 'date'
    ];

}
