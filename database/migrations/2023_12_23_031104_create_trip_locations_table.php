<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'trip_locations', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'trip_id' );
            $table->unsignedBigInteger( 'location_id' );

            $table->foreign( 'trip_id' )->references( 'id' )->on( 'trips' )->cascadeOnUpdate();
            $table->foreign( 'location_id' )->references( 'id' )->on( 'locations' )->cascadeOnUpdate();

            $table->decimal( 'price', 8, 2 )->nullable()->default( 0 );
            $table->timestamps();

        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'trip_locations' );
    }
};