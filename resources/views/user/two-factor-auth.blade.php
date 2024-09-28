@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Two-Factor Authentication</h4>
                    <a href="{{ url('/home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <hr>
                <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                    @csrf
                    @if (auth()->user()->two_factor_secret)
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Disable Two-Factor Authentication
                        </button>
                    @else
                        <button type="submit" class="btn btn-primary">
                            Enable Two-Factor Authentication
                        </button>
                    @endif
                </form>
                @if (auth()->user()->two_factor_secret)
                    <div>
                        <a href="{{ url('user/two-factor-qr') }}" class="btn btn-info mt-3">Show QR Code</a>
                        <a href="{{ url('user/two-factor-recovery-codes') }}" class="btn btn-info mt-3">Show Recovery
                            Codes</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
