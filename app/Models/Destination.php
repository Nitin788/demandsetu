<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destinations';
    protected $fillable = ['country_id', 'name', 'image', 'status'];

    // Define an inverse one-to-many relationship with country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function places(){
        return $this->hasMany(Place::class);
    }
}
