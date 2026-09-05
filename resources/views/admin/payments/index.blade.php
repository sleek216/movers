@extends('admin.layouts.app')

@section('title', 'Payment Gateways')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Payment Gateways</h4>
                <p class="text-muted mb-0">Configure payment gateways, credentials, and visibility in mobile app</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        @foreach($gateways as $gateway)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                @if($gateway->img)
                                    <img src="{{ asset($gateway->img) }}" height="35" class="me-2" alt="">
                                @endif
                                <h5 class="fw-bold mb-0">{{ $gateway->title }}</h5>
                            </div>
                            <div>
                                @if($gateway->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-muted f-13">{{ $gateway->subtitle ?: 'Online Payment Gateway' }}</p>
                    </div>

                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">Display Mode: {{ $gateway->p_show == 1 ? 'Live' : 'Sandbox' }}</small>
                        <a href="{{ route('admin.payments.edit', $gateway->id) }}" class="btn btn-sm btn-outline-primary">
                            <i data-feather="settings"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
