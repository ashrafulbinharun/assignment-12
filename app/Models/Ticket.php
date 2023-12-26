<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = ['user_id', 'trip_id', 'seat_number'];

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function trip() {
        return $this->belongsTo( Trip::class );
    }

}