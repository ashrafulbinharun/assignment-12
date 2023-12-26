<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'trips', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'from_location_id' );
            $table->unsignedBigInteger( 'to_location_id' );

            $table->foreign( 'from_location_id' )->references( 'id' )->on( 'locations' )->cascadeOnUpdate();
            $table->foreign( 'to_location_id' )->references( 'id' )->on( 'locations' )->cascadeOnUpdate();

            $table->dateTime( 'date' );
            $table->integer( 'available_seats' )->default( 36 );
            $table->boolean( 'round_trip' )->default( false );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'trips' );
    }
};