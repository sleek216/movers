@extends('admin.layouts.app')

@section('title', 'Load Booking #' . $load->id)

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Load Booking #{{ $load->id }}</h4>
                <p class="text-muted mb-0">Full route, load details, payment info, and transporter bids</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.loads.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-feather="arrow-left"></i> Back to Loads
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Load Status and Details Card -->
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Cargo & Consignment Information</h5>
                    <span class="badge bg-primary f-14">{{ $load->load_status }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Required Vehicle Type</span>
                                <h6 class="fw-bold mb-0 text-primary">{{ $load->vehicle_title ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Weight & Material</span>
                                <h6 class="fw-bold mb-0">{{ $load->weight }} Tons ({{ $load->material_name }})</h6>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <span class="text-success d-block f-12 fw-bold">● PICKUP POINT</span>
                                <p class="fw-semibold mb-1">{{ $load->pickup_point }}</p>
                                <small class="text-muted">Contact: {{ $load->pick_name }} ({{ $load->pick_mobile }})</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <span class="text-danger d-block f-12 fw-bold">● DROP POINT</span>
                                <p class="fw-semibold mb-1">{{ $load->drop_point }}</p>
                                <small class="text-muted">Contact: {{ $load->drop_name }} ({{ $load->drop_mobile }})</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Cargo Description / Instructions</span>
                                <p class="mb-0">{{ $load->description ?: 'No special instructions.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bids Received Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Transporter Bids ({{ count($bids) }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Transporter</th>
                                    <th>Lorry Number</th>
                                    <th>Bid Amount</th>
                                    <th>Status</th>
                                    <th>Bid Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bids as $bid)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $bid->owner_name ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $bid->owner_mobile ?? '' }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $bid->lorry_no ?? 'N/A' }}</span></td>
                                    <td><strong class="text-primary">${{ number_format($bid->total_amt ?? $bid->amount, 2) }}</strong></td>
                                    <td>
                                        @if($bid->status == 'Accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($bid->status == 'Rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $bid->description ?: '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No bids placed on this load yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="col-xl-4 mb-4">
            <!-- Customer Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Customer Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Name</span>
                            <strong>{{ $load->customer_name }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Mobile</span>
                            <strong>{{ $load->customer_mobile }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Email</span>
                            <span>{{ $load->customer_email }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Payment & Pricing</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Offered Amount</span>
                            <strong>${{ number_format($load->offer_price ?? $load->amount, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Platform Commission</span>
                            <strong class="text-success">${{ number_format($load->commission, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Total Amount</span>
                            <h5 class="mb-0 fw-bold text-primary">${{ number_format($load->total_amt ?? $load->amount, 2) }}</h5>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Assigned Transporter (if accepted) -->
            @if($load->lorry_owner_id)
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Assigned Transporter</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Transporter</span>
                            <strong>{{ $load->transporter_name }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Contact</span>
                            <strong>{{ $load->transporter_mobile }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Lorry Assigned</span>
                            <span class="badge bg-dark">{{ $load->lorry_no }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
