<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $fillable = ['name'];

    public function tripLocations() {
        return $this->hasMany( TripLocation::class );
    }

    public function trips() {
        return $this->belongsToMany( Trip::class, 'trip_locations' )
            ->withPivot( 'price' )
            ->withTimestamps();
    }

}