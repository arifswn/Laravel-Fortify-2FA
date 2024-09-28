@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Register</h4>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success my-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <hr>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Name</label> <input type="text"
                            class="form-control @error('name') is-invalid @enderror" placeholder="your name" name="name"
                            value="{{ old('name') }}"> @error('name')
                            <div class="invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="name@example.com" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="password" name="password">
                        @error('password')
                            <div class="invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Password Confirmation</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="password confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <button type="submit"class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
