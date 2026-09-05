@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Title Header -->
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="letter-spacing: -0.5px;">Freight Operations Dashboard</h3>
        <p class="text-muted mb-0">Live real-time monitoring of consignments, fleet, and financial metrics</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.payouts.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="bi bi-wallet2"></i> Payout Requests
        </a>
        <a href="{{ route('admin.payouts.earnings') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
            <i class="bi bi-graph-up-arrow"></i> Revenue Reports
        </a>
    </div>
</div>

<!-- Primary Stats Grid -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-title">Total Customers</span>
                <div class="stat-icon primary"><i class="bi bi-people-fill"></i></div>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
                <small class="text-muted d-block mt-1"><i class="bi bi-arrow-up-short text-success fw-bold"></i> Active registered clients</small>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-title">Transporters</span>
                <div class="stat-icon success"><i class="bi bi-person-badge-fill"></i></div>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalTransporters) }}</div>
                <small class="text-muted d-block mt-1"><i class="bi bi-check-circle text-success"></i> Fleet operators</small>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-title">Registered Lorries</span>
                <div class="stat-icon info"><i class="bi bi-truck-front-fill"></i></div>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalLorries) }}</div>
                <small class="text-muted d-block mt-1"><i class="bi bi-boxes"></i> Across {{ $totalVehicles }} categories</small>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-title">Total Consignments</span>
                <div class="stat-icon warning"><i class="bi bi-box-seam-fill"></i></div>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalLoads) }}</div>
                <small class="text-muted d-block mt-1"><i class="bi bi-clock-history"></i> Posted by clients</small>
            </div>
        </div>
    </div>
</div>

<!-- Load Booking Status Pipeline Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ route('admin.loads.byStatus', 'Pending') }}" class="text-decoration-none">
            <div class="card p-3 text-center mb-0 h-100 border-0 shadow-sm" style="background-color: #FFFBEB;">
                <span class="text-muted f-12 fw-bold text-uppercase d-block mb-1">Pending</span>
                <h4 class="fw-bold mb-0 text-warning">{{ $pendingLoads }}</h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ route('admin.loads.byStatus', 'Accepted') }}" class="text-decoration-none">
            <div class="card p-3 text-center mb-0 h-100 border-0 shadow-sm" style="background-color: #F0F9FF;">
                <span class="text-muted f-12 fw-bold text-uppercase d-block mb-1">Accepted</span>
                <h4 class="fw-bold mb-0 text-info">{{ $acceptedLoads }}</h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ route('admin.loads.byStatus', 'Pickup') }}" class="text-decoration-none">
            <div class="card p-3 text-center mb-0 h-100 border-0 shadow-sm" style="background-color: #EEF2FF;">
                <span class="text-muted f-12 fw-bold text-uppercase d-block mb-1">In-Pickup</span>
                <h4 class="fw-bold mb-0 text-primary">{{ $pickupLoads }}</h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ route('admin.loads.byStatus', 'Complete') }}" class="text-decoration-none">
            <div class="card p-3 text-center mb-0 h-100 border-0 shadow-sm" style="background-color: #ECFDF5;">
                <span class="text-muted f-12 fw-bold text-uppercase d-block mb-1">Completed</span>
                <h4 class="fw-bold mb-0 text-success">{{ $completedLoads }}</h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ route('admin.loads.byStatus', 'Cancelled') }}" class="text-decoration-none">
            <div class="card p-3 text-center mb-0 h-100 border-0 shadow-sm" style="background-color: #FEF2F2;">
                <span class="text-muted f-12 fw-bold text-uppercase d-block mb-1">Cancelled</span>
                <h4 class="fw-bold mb-0 text-danger">{{ $cancelledLoads }}</h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ route('admin.payouts.earnings') }}" class="text-decoration-none">
            <div class="card p-3 text-center mb-0 h-100 border-0 shadow-sm bg-dark text-white">
                <span class="text-white-50 f-12 fw-bold text-uppercase d-block mb-1">Revenue</span>
                <h4 class="fw-bold mb-0 text-white">${{ number_format($totalEarnings, 0) }}</h4>
            </div>
        </a>
    </div>
</div>

<!-- Main Activity & Lists Section -->
<div class="row g-4">
    <!-- Recent Consignments Table -->
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header">
                <div>
                    <h5>Recent Load Consignments</h5>
                    <small class="text-muted">Latest cargo posts created by clients</small>
                </div>
                <a href="{{ route('admin.loads.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Client</th>
                                <th>Pickup & Drop Route</th>
                                <th>Weight</th>
                                <th>Fare</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLoads as $load)
                            <tr>
                                <td><span class="fw-bold text-secondary">#{{ $load->id }}</span></td>
                                <td>
                                    <div class="fw-bold">{{ $load->user_name ?? 'Client #' . $load->uid }}</div>
                                    <small class="text-muted">{{ $load->user_mobile ?? '' }}</small>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $load->pickup_point }}">
                                            <i class="bi bi-geo-alt-fill text-success me-1"></i> {{ $load->pickup_point }}
                                        </div>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $load->drop_point }}">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $load->drop_point }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $load->weight }} Tons</span>
                                    <small class="text-muted d-block">{{ $load->material_name }}</small>
                                </td>
                                <td>
                                    <strong class="text-primary">${{ number_format($load->total_amt ?? $load->amount, 2) }}</strong>
                                </td>
                                <td>
                                    @if($load->load_status == 'Pending')
                                        <span class="badge badge-soft-warning">Pending</span>
                                    @elseif($load->load_status == 'Accepted')
                                        <span class="badge badge-soft-info">Accepted</span>
                                    @elseif($load->load_status == 'Pickup')
                                        <span class="badge badge-soft-primary">In Pickup</span>
                                    @elseif($load->load_status == 'Complete')
                                        <span class="badge badge-soft-success">Complete</span>
                                    @else
                                        <span class="badge badge-soft-danger">{{ $load->load_status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.loads.show', $load->id) }}" class="btn btn-sm btn-light text-primary">
                                        <i class="bi bi-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                    No load consignments recorded yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Recent Transporters & Quick Actions -->
    <div class="col-12 col-xl-4">
        <!-- Transporters Card -->
        <div class="card mb-4">
            <div class="card-header">
                <div>
                    <h5>Recent Transporters</h5>
                    <small class="text-muted">Newly onboarded fleet owners</small>
                </div>
                <a href="{{ route('admin.owners.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentTransporters as $owner)
                    <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light-primary text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-size: 0.95rem;">
                                {{ strtoupper(substr($owner->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold fs-6">{{ $owner->name }}</h6>
                                <small class="text-muted">{{ $owner->mobile }}</small>
                            </div>
                        </div>
                        <div>
                            @if($owner->is_verify == 1)
                                <span class="badge badge-soft-success"><i class="bi bi-check-circle-fill me-1"></i> Verified</span>
                            @elseif($owner->is_verify == 2)
                                <span class="badge badge-soft-danger"><i class="bi bi-x-circle-fill me-1"></i> Rejected</span>
                            @else
                                <span class="badge badge-soft-warning"><i class="bi bi-clock-fill me-1"></i> Review</span>
                            @endif
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">No transporters registered yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- System Quick Actions Card -->
        <div class="card">
            <div class="card-header">
                <h5>Platform Management</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.vehicles.create') }}" class="btn btn-light d-flex align-items-center justify-content-between p-3 text-start">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon primary" style="width: 36px; height: 36px; font-size: 1.1rem;"><i class="bi bi-plus-circle-fill"></i></div>
                        <div>
                            <div class="fw-bold">Add Vehicle Category</div>
                            <small class="text-muted">Configure weight limits & icons</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>

                <a href="{{ route('admin.banners.create') }}" class="btn btn-light d-flex align-items-center justify-content-between p-3 text-start">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon warning" style="width: 36px; height: 36px; font-size: 1.1rem;"><i class="bi bi-image-fill"></i></div>
                        <div>
                            <div class="fw-bold">Upload Promotional Banner</div>
                            <small class="text-muted">Home screen promo sliders</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="btn btn-light d-flex align-items-center justify-content-between p-3 text-start">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon success" style="width: 36px; height: 36px; font-size: 1.1rem;"><i class="bi bi-sliders"></i></div>
                        <div>
                            <div class="fw-bold">System API & Keys</div>
                            <small class="text-muted">OneSignal, SMS, and Map settings</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
