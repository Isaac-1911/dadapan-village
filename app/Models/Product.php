<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'seller_profile_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'thumbnail',
        'status'

    ];

    public function sellerProfile(){
        return $this->belongsTo(SellerProfile::class);
    }

    public function category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }
}
