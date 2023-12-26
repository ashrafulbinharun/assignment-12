@extends('layout.master')

@section('content')
    <div class="col-lg-6 offset-lg-3">
        <h2>Create Location</h2>

        <form action="{{ route('locations.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Location Name:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Add Location</button>
                <a href="{{ route('locations.index') }}" class="btn btn-secondary">Go Back</a>
            </div>
        </form>
    </div>
@endsection
