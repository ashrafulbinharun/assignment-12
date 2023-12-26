<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class TicketConfirmController extends Controller {
    public function show( $user, $ticketCount, $totalPrice, Trip $trip ) {
        return view( 'pages.tickets_confirm', compact( 'user', 'ticketCount', 'totalPrice', 'trip' ) );
    }
}