<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    protected $table = 'homepages';
    protected $fillable = ['banner_image_title', 'offer_image', 'offer_card'];
    protected $casts = [
        'slider_images' => 'array',
        'offer_image' => 'array',
        'offer_card' => 'array',
    ];
}