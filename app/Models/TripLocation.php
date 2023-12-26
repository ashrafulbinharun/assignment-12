<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripLocation extends Model {
    protected $fillable = ['trip_id', 'location_id', 'price', 'location_order'];

    public function location() {
        return $this->belongsTo( Location::class );
    }
}