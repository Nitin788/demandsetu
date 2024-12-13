<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';
    protected $fillable = [
        'destination_id',
        'title',
        'about',
        'images',
        'offers',
        'duration',
        'price',
        'sale_price',
        'slug',
        'description',
        'itinerary',
    ];
    public function destination(){
        return $this->belongsTo(Destination::class);
    }
}
