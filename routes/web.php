<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\TicketConfirmController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

// Trip Routes
Route::get( '/', [TripController::class, 'index'] )->name( 'home' );
Route::get( '/trips/create', [TripController::class, 'create'] )->name( 'trips.create' );
Route::post( '/trips', [TripController::class, 'store'] )->name( 'trips.store' );
Route::get( '/trips/{trip}/edit', [TripController::class, 'edit'] )->name( 'trips.edit' );
Route::put( '/trips/{trip}', [TripController::class, 'update'] )->name( 'trips.update' );
Route::delete( '/trips/{trip}', [TripController::class, 'destroy'] )->name( 'trips.destroy' );

// Ticket Routes
Route::get( '/tickets/create/{trip}', [TicketController::class, 'create'] )->name( 'tickets.create' );
Route::post( '/tickets/store', [TicketController::class, 'store'] )->name( 'tickets.store' );
Route::get( '/tickets/confirmation', [TicketConfirmController::class, 'show'] )->name( 'tickets.confirmation' );

// Location Routes
Route::get( '/locations', [LocationController::class, 'index'] )->name( 'locations.index' );
Route::get( '/locations/create', [LocationController::class, 'create'] )->name( 'locations.create' );
Route::post( '/locations', [LocationController::class, 'store'] )->name( 'locations.store' );
Route::get( '/locations/{location}/edit', [LocationController::class, 'edit'] )->name( 'locations.edit' );
Route::put( '/locations/{location}', [LocationController::class, 'update'] )->name( 'locations.update' );
Route::delete( '/locations/{location}', [LocationController::class, 'destroy'] )->name( 'locations.destroy' );