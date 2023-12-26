@extends('layout.master')

@section('content')
    <h2 class="mb-3">Available Trips</h2>

    @if ($availableTrips->isEmpty())
        <div class="alert alert-info" role="alert">
            <h6>No available trips at the moment.</h6>
        </div>
    @else
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search --}}
        <form action="{{ route('home') }}" method="GET" class="row gx-3 gy-2 align-items-center mb-4">
            <div class="col-lg-3">
                <label for="searchDate" class="mb-1">Search by Date:</label>
                <input type="date" name="date" id="searchDate" class="form-control mr-2"
                    value="{{ $request->input('date', '') }}">
            </div>

            <div class="col-lg-1 offset-lg-8">
                <button type="submit" class="btn btn-primary mt-3 me-2">Search</button>
            </div>
        </form>

        {{-- Trips --}}
        <div class="row">
            @foreach ($availableTrips as $trip)
                @if ($trip->isAvailable)
                    <div class="col-lg-4 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Bus Route:
                                    {{ $trip->fromLocation->name }} to
                                    {{ $trip->toLocation->name }}
                                </h5>
                                <div class="card-text">
                                    <p class="mb-2">Departure Date: {{ $trip->date->format('Y-m-d ') }}</p>
                                    <p class="mb-2">Departure Time: {{ $trip->date->format('H:i A') }}</p>
                                    <p class="mb-2"> Available Seats: {{ $trip->available_seats }}</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="me-auto">
                                        <a href="{{ route('tickets.create', $trip->id) }}" class="btn btn-primary">Buy
                                            Tickets</a>
                                    </div>

                                    <div class="d-flex">
                                        <div>
                                            <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>

                                        <div class="ms-2">
                                            <form action="{{ route('trips.destroy', $trip->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Pagination links  --}}
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="d-flex justify-content-center mt-4">
                    @if ($availableTrips->currentPage() > 1)
                        <a href="{{ $availableTrips->previousPageUrl() }}" class="btn btn-primary me-2">Previous</a>
                    @endif

                    @if ($availableTrips->hasMorePages())
                        <a href="{{ $availableTrips->nextPageUrl() }}" class="btn btn-primary">Next</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
