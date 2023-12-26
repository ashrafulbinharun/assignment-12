<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $fillable = ['name', 'email', 'phone_number'];

    public function tickets() {
        return $this->hasMany( Ticket::class );
    }

}