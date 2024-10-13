@extends('layouts.app')

@section('content')
    <div class="alert alert-success">
        <h4 class="alert-heading">Registration Successful!</h4>
        <p>
            Dear <b>{{ $user->name }}</b>,
            <br>
            <b>As-salamu alaykum</b>
            <br>
            your vaccination appointment has been successfully registered.
        </p>
        <p>Status: <strong>{{ $user->appointment->status->text() }}</strong></p>
        @if($user->appointment->scheduled_date && $user->appointment->isScheduled)
            <p>Your next appointment is on <strong>{{ $user->appointment->scheduled_date }}</strong>.</p>
        @endif
        <hr>
        <p class="mb-0">Thank you for registering!</p>
    </div>
@endsection
