@extends('layout.master')

@section('content')
    <div class="col-lg-6 offset-lg-3">
        <h2>Edit Location</h2>

        <form action="{{ route('locations.update', $location) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Location Name:</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $location->name) }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Update Location</button>
                <a href="{{ route('locations.index') }}" class="btn btn-secondary">Go Back</a>
            </div>
        </form>
    </div>
@endsection
