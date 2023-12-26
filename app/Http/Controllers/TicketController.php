<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TicketConfirmController;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller {
    public function create( Trip $trip ) {

        $trips = Trip::with( 'locations' )->where( 'date', '>=', now() )->get();

        $trips->transform( function ( $trip ) {
            $trip->date = Carbon::parse( $trip->date );
            return $trip;
        } );

        // $selectedTrip    = $trip;
        // $uniqueLocations = $selectedTrip->locations->unique( 'id' );

        $selectedTrip    = Trip::with( 'locations' )->find( $trip->id );
        $uniqueLocations = $selectedTrip->locations->unique( 'id' );

        return view( 'pages.tickets', compact( 'trips', 'selectedTrip', 'uniqueLocations' ) );
    }

    public function store( Request $request, TicketConfirmController $confirmationController ) {

        $request->validate( [
            'name'         => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:50',
            'phone_number' => 'required|string|max:15',
            'seat_number'  => 'required|integer',
            'trip_id'      => 'required|exists:trips,id',
        ] );

        DB::beginTransaction();

        try {

            $user = User::firstOrCreate(
                ['email' => $request->input( 'email' )],
                [
                    'name'         => $request->input( 'name' ),
                    'phone_number' => $request->input( 'phone_number' ),
                ]
            );

            $trip               = Trip::with( 'locations' )->find( $request->input( 'trip_id' ) );
            $numberOfSeats      = $request->input( 'seat_number' );
            $selectedLocationId = $request->input( 'selected_location_id' );

            $selectedLocation = $trip->locations->find( $selectedLocationId );

            if ( !$selectedLocation ) {

                DB::rollback();
                return redirect()->back()->with( 'error', 'Invalid location selected.' );
            }

            $totalPrice = $numberOfSeats * ( $selectedLocation->pivot->price ?? 0 );

            if ( $trip->available_seats >= $numberOfSeats ) {

                $trip->decrement( 'available_seats', $numberOfSeats );
                DB::commit();

                return $confirmationController->show( $user, $numberOfSeats, $totalPrice, $trip );

            } else {
                DB::rollback();

                return redirect()->back()->with( 'error', 'Not enough available seats.' );
            }
        } catch ( \Exception $e ) {

            DB::rollback();
            return redirect()->back()->with( 'error', 'Failed to create ticket. Please try again.' );
        }
    }
}