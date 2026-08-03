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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
