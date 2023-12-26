@extends('layout.master')

@section('content')
    <div class="col-lg-8 offset-lg-2">
        <div class="card mt-4">

            <div class="card-header">
                <h2 class="text-center">Ticket Confirmation</h2>
            </div>

            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Confirm Card --}}
                <div class="alert alert-success card">
                    <p class="lead text-center">Congratulations, {{ $user->name }}! Your ticket has been successfully
                        created.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Phone Number:</strong> {{ $user->phone_number }}</li>
                        <li class="list-group-item"><strong>Route:</strong> {{ $trip->fromLocation->name }} to
                            {{ $trip->toLocation->name }}</li>
                        <li class="list-group-item"><strong>Seat Count:</strong> {{ $ticketCount }}</li>
                        <li class="list-group-item"><strong>Total Price:</strong> {{ $totalPrice }} Taka Only</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
