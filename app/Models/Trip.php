<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model {
    protected $fillable = ['from_location_id', 'to_location_id', 'date', 'available_seats', 'round_trip'];

    protected $dates = ['date'];

    public function fromLocation() {
        return $this->belongsTo( Location::class, 'from_location_id' );
    }

    public function toLocation() {
        return $this->belongsTo( Location::class, 'to_location_id' );
    }

    public function tickets() {
        return $this->hasMany( Ticket::class );
    }

    public function tripLocations() {
        return $this->hasMany( TripLocation::class )->orderBy( 'location_order' );
    }

    public function locations() {
        return $this->belongsToMany( Location::class, 'trip_locations' )
            ->withPivot( 'price' )
            ->withTimestamps();
    }

}