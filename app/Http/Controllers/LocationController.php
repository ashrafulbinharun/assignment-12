<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller {
    public function index() {
        $locations = Location::all();
        return view( 'pages.locations.location_index', compact( 'locations' ) );
    }

    public function create() {
        return view( 'pages.locations.location_create' );
    }

    public function store( Request $request ) {
        $request->validate( [
            'name' => 'required|unique:locations|max:255',
        ] );

        Location::create( ['name' => $request->name] );

        return redirect()->route( 'locations.index' )
            ->with( 'success', 'Location added successfully.' );
    }

    public function edit( Location $location ) {
        return view( 'pages.locations.location_edit', compact( 'location' ) );
    }

    public function update( Request $request, Location $location ) {
        $request->validate( [
            'name' => 'required|unique:locations|max:255',
        ] );

        $location->update( ['name' => $request->name] );

        return redirect()->route( 'locations.index' )
            ->with( 'success', 'Location updated successfully.' );
    }

    public function destroy( Location $location ) {
        $location->delete();

        return redirect()->route( 'locations.index' )
            ->with( 'success', 'Location deleted successfully.' );
    }
}