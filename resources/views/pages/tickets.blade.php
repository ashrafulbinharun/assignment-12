@extends('layout.master')

@section('content')
    <div class="col-lg-8 offset-lg-2">
        <h2 class="mb-4 text-center">Buy Tickets</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('tickets.store') }}" method="POST" id="ticket-form">

            @csrf
            <div class="row">
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name (optional)</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your name" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email (optional)</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="{{ old('phone_number') }}" placeholder="Enter your phone number">
                        @error('phone_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="seat_number" class="form-label">Seat Count</label>
                        <input type="number" class="form-control" id="seat_number" name="seat_number"
                            value="{{ old('seat_number') }}" placeholder="Enter seat number">
                        @error('seat_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location_id" class="form-label">Select Location</label>
                        <select class="form-select" id="location_id" name="location_id" required>
                            @foreach ($uniqueLocations as $location)
                                <option value="{{ $location->id }}" data-price="{{ $location->pivot->price }}"
                                    {{ old('location_id') == $location->id ? 'selected' : '' }}>

                                    {{ $location->name }} - Price: {{ $location->pivot->price }}

                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="trip_id" value="{{ $selectedTrip->id }}">
                    <input type="hidden" name="selected_location_id" id="selected_location_id" value="">

                    <button type="submit" class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.getElementById('location_id').addEventListener('change', function() {
                document.getElementById('selected_location_id').value = this.value;
            });
        </script>
    @endpush
@endsection
