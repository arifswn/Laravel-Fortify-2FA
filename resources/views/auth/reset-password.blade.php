@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Reset Password</h4>
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
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->token }}">
                    <div class="form-group">
                        <label class="font-weight-bold text-uppercase">Email address</label>
                        <input type="email" name="email" value="{{ $request->email }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email address">
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-uppercase">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter new password">
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-uppercase">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Reset Password</button>
                </form>
            </div>
        </div>
        <div class="register mt-3 text-center">
            <p>Remember your password? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
@endsection
