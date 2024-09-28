@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Verify Email</h4>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success my-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success my-2" role="alert">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif
                <hr>
                <p>
                    Before proceeding, please check your email for a verification link. If you did not receive the email,
                    you can request another by clicking the button below.
                </p>
                <div class="button-container" style="display: flex; justify-content: space-between;">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-envelope"></i> Resend Verification Email
                        </button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
