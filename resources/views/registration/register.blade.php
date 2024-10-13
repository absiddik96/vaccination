@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Vaccine Registration</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('registration.register') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nid">National ID (NID)</label>
                                <input type="text" class="form-control @error('nid') is-invalid @enderror" id="nid" name="nid" value="{{ old('nid') }}" required>
                                @error('nid')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="vaccine_center">Select Vaccine Center</label>
                                <select class="form-control @error('vaccine_center') is-invalid @enderror" id="vaccine_center" name="vaccine_center" required>
                                    <option value="">-- Select a Center --</option>
                                    @foreach($vaccineCenters as $center)
                                        <option value="{{ $center->id }}" {{ old('vaccine_center') == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                                    @endforeach
                                </select>
                                @error('vaccine_center')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
