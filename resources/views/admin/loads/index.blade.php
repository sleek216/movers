@extends('admin.layouts.app')

@section('title', $currentStatus . ' Loads')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">{{ $currentStatus }} Loads</h4>
                <p class="text-muted mb-0">Overview and tracking of freight consignments</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.loads.index') }}" class="btn {{ $currentStatus == 'All' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
                    <a href="{{ route('admin.loads.byStatus', 'Pending') }}" class="btn {{ $currentStatus == 'Pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pending</a>
                    <a href="{{ route('admin.loads.byStatus', 'Accepted') }}" class="btn {{ $currentStatus == 'Accepted' ? 'btn-info' : 'btn-outline-info' }}">Accepted</a>
                    <a href="{{ route('admin.loads.byStatus', 'Pickup') }}" class="btn {{ $currentStatus == 'Pickup' ? 'btn-primary' : 'btn-outline-primary' }}">Pickup</a>
                    <a href="{{ route('admin.loads.byStatus', 'Complete') }}" class="btn {{ $currentStatus == 'Complete' ? 'btn-success' : 'btn-outline-success' }}">Complete</a>
                    <a href="{{ route('admin.loads.byStatus', 'Cancelled') }}" class="btn {{ $currentStatus == 'Cancelled' ? 'btn-danger' : 'btn-outline-danger' }}">Cancelled</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Customer</th>
                            <th>Vehicle Type</th>
                            <th>Pickup Location</th>
                            <th>Drop Location</th>
                            <th>Material & Weight</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loads as $load)
                        <tr>
                            <td><strong>#{{ $load->id }}</strong></td>
                            <td>
                                <div class="fw-semibold">{{ $load->customer_name ?? 'User #' . $load->uid }}</div>
                                <small class="text-muted">{{ $load->customer_mobile ?? '' }}</small>
                            </td>
                            <td>{{ $load->vehicle_title ?? 'N/A' }}</td>
                            <td><span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $load->pickup_point }}">{{ $load->pickup_point }}</span></td>
                            <td><span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $load->drop_point }}">{{ $load->drop_point }}</span></td>
                            <td>
                                <div>{{ $load->material_name }}</div>
                                <small class="text-muted">{{ $load->weight }} Tons</small>
                            </td>
                            <td>
                                <strong>${{ number_format($load->total_amt ?? $load->amount, 2) }}</strong>
                            </td>
                            <td>
                                @if($load->load_status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($load->load_status == 'Accepted')
                                    <span class="badge bg-info">Accepted</span>
                                @elseif($load->load_status == 'Pickup')
                                    <span class="badge bg-primary">In Pickup</span>
                                @elseif($load->load_status == 'Complete')
                                    <span class="badge bg-success">Complete</span>
                                @else
                                    <span class="badge bg-danger">{{ $load->load_status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.loads.show', $load->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i data-feather="eye"></i> View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
