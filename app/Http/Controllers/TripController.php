<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller {
    public function index( Request $request ) {

        $perPage = $request->perPage ?? 6;

        $query = Trip::where( 'date', '>=', now() );

        if ( $request->has( 'date' ) ) {
            $inputDate = Carbon::parse( $request->input( 'date' ) )->format( 'Y-m-d' );
            $query->whereDate( 'date', '=', $inputDate );
        }

        $query->orderByDesc( 'date' );

        $availableTrips = $query->paginate( $perPage )->appends( request()->query() );

        $availableTrips->getCollection()->transform( function ( $trip ) {
            $trip->date        = Carbon::parse( $trip->date );
            $trip->isAvailable = $trip->date->isFuture() && $trip->available_seats > 0;

            return $trip;
        } );

        return view( 'pages.index', compact( 'availableTrips', 'request' ) );
    }

    public function create() {
        $locations = Location::all();
        return view( 'pages.trips_create', compact( 'locations' ) );
    }

    public function store( Request $request ) {

        $request->validate( [
            'from_location_id' => 'required|exists:locations,id',
            'to_location_id'   => 'required|exists:locations,id',
            'date'             => 'required|date',
            'available_seats'  => 'required|integer',
            'round_trip'       => 'boolean',
        ] );

        DB::beginTransaction();

        try {

            $trip = Trip::create( [
                'from_location_id' => $request->input( 'from_location_id' ),
                'to_location_id'   => $request->input( 'to_location_id' ),
                'date'             => Carbon::parse( $request->input( 'date' ) ),
                'available_seats'  => $request->input( 'available_seats' ),
                'round_trip'       => $request->input( 'round_trip', false ),
            ] );

            $this->saveLocationPrices( $request, $trip );

            // round trip
            if ( $request->input( 'round_trip' ) ) {
                $returnTrip = Trip::create( [
                    'from_location_id' => $request->input( 'to_location_id' ),
                    'to_location_id'   => $request->input( 'from_location_id' ),
                    'date'             => $request->input( 'date' ),
                    'available_seats'  => $request->input( 'available_seats' ),
                    'round_trip'       => true,
                ] );

                $this->saveLocationPrices( $request, $returnTrip );
            }

            DB::commit();

            return redirect()->route( 'home' )->with( 'success', 'Trip(s) created successfully.' );

        } catch ( \Exception $e ) {

            DB::rollback();

            return redirect()->route( 'home' )->with( 'error', 'Failed to create trip. Please try again.' );
        }
    }

    protected function saveLocationPrices( Request $request, Trip $trip ) {

        $locationPrices = [];

        foreach ( $request->input() as $key => $value ) {
            if ( strpos( $key, 'location_' ) === 0 && strpos( $key, '_price' ) !== false ) {
                $locationId = substr( $key, strlen( 'location_' ), -strlen( '_price' ) );
                $price      = !empty( $value ) ? $value : null;

                $locationPrices[$locationId] = ['price' => $price, 'trip_id' => $trip->id];
            }
        }

        $trip->locations()->sync( $locationPrices );
    }

    public function edit( Trip $trip ) {
        $locations  = Location::all();
        $trip->date = Carbon::parse( $trip->date );
        return view( 'pages.trips_edit', compact( 'trip', 'locations' ) );
    }

    public function update( Request $request, Trip $trip ) {

        $request->validate( [
            'from_location_id' => 'required|exists:locations,id',
            'to_location_id'   => 'required|exists:locations,id',
            'date'             => 'required|date',
            'available_seats'  => 'required|integer',
            'round_trip'       => 'boolean',
        ] );

        DB::beginTransaction();

        try {
            $trip->update( [
                'from_location_id' => $request->input( 'from_location_id' ),
                'to_location_id'   => $request->input( 'to_location_id' ),
                'date'             => Carbon::parse( $request->input( 'date' ) ),
                'available_seats'  => $request->input( 'available_seats' ),
                'round_trip'       => $request->input( 'round_trip', false ),
            ] );

            $this->saveLocationPrices( $request, $trip );

            DB::commit();

            return redirect()->route( 'home' )->with( 'success', 'Trip updated successfully.' );

        } catch ( \Exception $e ) {

            DB::rollback();

            return redirect()->route( 'home' )->with( 'error', 'Failed to update trip. Please try again.' );
        }
    }

    public function destroy( Trip $trip ) {

        DB::beginTransaction();

        try {
            $trip->locations()->detach();
            $trip->delete();

            DB::commit();

            return redirect()->route( 'home' )->with( 'success', 'Trip deleted successfully.' );

        } catch ( \Exception $e ) {

            DB::rollback();

            return redirect()->route( 'home' )->with( 'error', 'Failed to delete trip. Please try again.' );
        }
    }

}