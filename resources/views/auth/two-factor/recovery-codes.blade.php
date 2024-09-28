@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="font-weight-bold mb-0">Recovery Codes</h4>
                    <a href="{{ url('/home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                @if (session('status'))
                    <div class="alert alert-success my-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        @if ($recoveryCodes)
                            <h4 class="mb-3">Your Recovery Codes</h4>
                            <ul>
                                @foreach ($recoveryCodes as $code)
                                    <li>{{ $code }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No recovery codes available. Generate new ones if needed.</p>
                        @endif

                        @php
                            $user = Auth::user();
                            $now = \Carbon\Carbon::now();
                            $lastGeneratedAt = $user->recovery_codes_generated_at;
                            $canGenerateNew = !$lastGeneratedAt || $lastGeneratedAt->diffInHours($now) > 24;
                        @endphp

                        @if ($lastGeneratedAt && $lastGeneratedAt->diffInHours($now) <= 24)
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="text-danger">
                                    You can only generate recovery codes once every 24 hours. Please try again later.
                                </span>
                            </div>
                        @else
                            <form action="{{ route('two-factor.recovery-codes.generate') }}" method="post">
                                @csrf
                                @method('post')
                                <button type="submit" class="btn {{ $recoveryCodes ? 'btn-warning' : 'btn-primary' }}">
                                    <i class="fas {{ $recoveryCodes ? 'fa-sync' : 'fa-key' }}"></i>
                                    {{ $recoveryCodes ? 'Generate New' : 'Generate' }} Recovery Codes
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
