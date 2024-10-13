@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!request()->query('nid'))
            <h2>Check Vaccination Status</h2>
            <form action="{{ route('status.check') }}">
                <div class="mb-3">
                    <label for="nid" class="form-label">National ID</label>
                    <input type="text" name="nid" class="form-control" id="nid" required>
                </div>
                <button type="submit" class="btn btn-primary">Check Status</button>
            </form>
        @else
            @if($user)
                <p>
                    Dear <b>{{ $user->name }}</b>,
                    <br>
                    <b>As-salamu alaykum</b>
                </p>
                <p>
                    Status: <strong>{{ $user->appointment->status->text() }}</strong>
                    @if($user->appointment->scheduled_date && $user->appointment->isScheduled)
                        <br>Your next appointment is on <strong>{{ $user->appointment->scheduled_date }}</strong>.
                    @endif
                </p>
            @else
                <p>
                    Dear User,
                    <br>
                    <b>As-salamu alaykum</b>
                </p>
                <p>
                    It seems that you are not registered yet. To ensure you receive your vaccination on time, please complete your registration first.
                    <br>
                    If you would like to register now, please <a href="{{ route('registration.show-form') }}">click here</a> to begin the process.
                </p>
                <p>
                    Thank you for your understanding, and we look forward to assisting you.
                </p>
            @endif

        @endif
    </div>
@endsection
