@extends('layout.master')

@section('content')
    <div class="col-lg-8 offset-lg-2">

        <h2 class="text-center mb-4">Edit Trip</h2>
        <form method="POST" action="{{ route('trips.update', $trip->id) }}">

            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">

                    <fieldset>
                        {{-- Location --}}
                        <legend class="fw-medium">Locations</legend>
                        <div class="form-group mb-3">
                            <label for="from_location_id">From Location:</label>
                            <select name="from_location_id" class="form-control">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ $location->id == $trip->from_location_id ? 'selected' : '' }}
                                        {{ (old('from_location_id') ?? $trip->from_location_id) == $location->id ? 'selected' : '' }}>

                                        {{ $location->name }}

                                    </option>
                                @endforeach
                            </select>
                            @error('from_location_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="to_location_id">To Location:</label>
                            <select name="to_location_id" class="form-control">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ $location->id == $trip->to_location_id ? 'selected' : '' }}
                                        {{ (old('from_location_id') ?? $trip->to_location_id) == $location->id ? 'selected' : '' }}>

                                        {{ $location->name }}

                                    </option>
                                @endforeach
                            </select>
                            @error('to_location_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset>
                        {{-- Details --}}
                        <legend class="fw-medium">Details</legend>
                        <div class="form-group mb-3">
                            <label for="datetime">Date and Time:</label>
                            <input type="datetime-local" name="date" class="form-control"
                                value="{{ old('date') ?? $trip->date->format('Y-m-d\TH:i') }}">
                            @error('date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="available_seats">Available Seats:</label>
                            <input type="number" name="available_seats" class="form-control"
                                value="{{ old('available_seats') ?? $trip->available_seats }}">
                            @error('available_seats')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <div class="col-lg-6">
                    <fieldset>
                        {{-- Location & Price --}}
                        <legend class="fw-medium">Prices</legend>
                        @foreach ($locations as $location)
                            <div class="form-group mb-3">
                                <label for="location_{{ $location->id }}_price">{{ $location->name }} Price:</label>

                                <input type="number" name="location_{{ $location->id }}_price" class="form-control"
                                    value="{{ old('location_' . $location->id . '_price') ?? ($trip->locations->where('id', $location->id)->first()->pivot->price ?? '') }}">

                            </div>
                            @error('location_' . $location->id . '_price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        @endforeach

                        <div class="form-group mb-3">
                            <div class="form-check">

                                <input type="checkbox" name="round_trip" value="1" class="form-check-input"
                                    id="roundTrip" {{ old('round_trip') ?? $trip->round_trip ? 'checked' : '' }}>

                                <label class="form-check-label" for="roundTrip">Round Trip</label>
                            </div>
                            @error('round_trip')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Trip</button>
            <a href="{{ route('home') }}" class="btn btn-secondary ms-2">Go Back</a>
        </form>
    </div>
@endsection
