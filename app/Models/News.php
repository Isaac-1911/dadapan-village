<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class News extends Model
{
    use HasFactory, Notifiable;


    protected $fillable = [

        'category_id',
        'author_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'published_at',
        'status'

    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean'
    ];

    public function category(){
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

}
