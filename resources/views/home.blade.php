@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="font-weight-bold mb-0">Welcome, <strong>{{ auth()->user()->name }}</strong>!</h4>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <p class="card-text mb-4">
                    This is your dashboard where you can manage your account and view important information.
                </p>

                @if (session('status'))
                    <div class="alert alert-success my-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <hr>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4 class="mb-3">Your Profile</h4>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-user"></i> Edit Profile
                        </a>
                    </div>

                    <div class="col-md-6">
                        <h4 class="mb-3">Account Actions</h4>
                        <a href="{{ route('logout') }}" class="btn btn-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">Two-Factor Authentication</h4>
                        @if (auth()->user()->two_factor_confirmed)
                            <form action="{{ route('two-factor.delete') }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-lock"></i> Disable 2FA
                                </button>
                            </form>
                        @elseif(auth()->user()->two_factor_secret)
                            <p>To complete the two-factor authentication setup, scan the QR code below and enter the
                                generated code.</p>
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            <form action="{{ route('two-factor.confirm') }}" method="post" class="mt-2">
                                @csrf
                                <input name="code" type="text" class="form-control" required autofocus
                                    placeholder="Enter the code">
                                @if ($errors->any())
                                    <div class="alert alert-danger my-2" role="alert">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary mt-2">
                                    <i class="fas fa-lock"></i> Confirm 2FA
                                </button>
                            </form>
                        @else
                            <form action="{{ route('two-factor.enable') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-lock"></i> Enable 2FA
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">Recovery Codes</h4>
                        @php
                            $user = auth()->user();
                            $recoveryCodes = $user->recoveryCodes();
                            $is2FAEnabled =
                                !is_null($user->two_factor_secret) && !is_null($user->two_factor_confirmed_at);
                        @endphp
                        @if ($is2FAEnabled)
                            @if (count($recoveryCodes) > 0)
                                <p>
                                    Your recovery codes are below. Keep them safe and use them to regain access if you
                                    lose your 2FA device.
                                </p>
                                <a href="{{ route('two-factor.recovery-codes.index') }}" class="btn btn-primary">
                                    <i class="fas fa-sync"></i> Recovery Codes
                                </a>
                            @else
                                <p>You don't have any recovery codes. Please generate them to ensure you can regain
                                    access if needed.</p>
                                <a href="{{ route('two-factor.recovery-codes.index') }}" class="btn btn-primary">
                                    <i class="fas fa-sync"></i> Generate Codes
                                </a>
                            @endif
                        @else
                            <p>Two-factor authentication is not enabled. Can`t generate recovery codes.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
