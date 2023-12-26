@extends('layout.master')

@section('content')
    <div class="col-lg-6 offset-lg-3">
        <h2>Locations</h2>

        @if ($locations->isEmpty())
            <div class="alert alert-info" role="alert">
                <h6>No Locations Available.</h6>
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

            {{-- All Locations --}}
            <ul class="list-group">
                @forelse($locations as $location)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $location->name }}
                        <div class="btn-group">
                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-primary rounded mx-2">Edit</a>
                            <form action="{{ route('locations.destroy', $location) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item">No locations available</li>
                @endforelse
            </ul>
        @endif

        <a href="{{ route('locations.create') }}" class="btn btn-success mt-3">Add Location</a>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3 ms-2">Home</a>
    </div>
    </div>
@endsection
