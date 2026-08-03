<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SellerProfile extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'business_name',
        'slug',
        'owner_name',
        'description',
        'address',
        'whatsapp',
        'logo'
    ];
}
