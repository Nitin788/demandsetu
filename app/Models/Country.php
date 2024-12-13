<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['name', 'image', 'status'];
    // Define a one-to-many relationship with destinations
    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }

}
