@extends('admin.layouts.app')

@section('title', 'Lorry Fleet')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Lorry Fleet Management</h4>
                <p class="text-muted mb-0">Registered trucks/lorries, verification documents and status</p>
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
                            <th>Vehicle Type</th>
                            <th>Lorry Number</th>
                            <th>Transporter / Owner</th>
                            <th>Weight Capacity</th>
                            <th>Current Location</th>
                            <th>Verification</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lorries as $lorry)
                        <tr>
                            <td><strong>#{{ $lorry->id }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($lorry->vehicle_img)
                                        <img src="{{ asset($lorry->vehicle_img) }}" width="40" height="40" class="me-2 rounded" alt="">
                                    @endif
                                    <span class="fw-semibold">{{ $lorry->vehicle_title ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border fw-bold f-14">{{ $lorry->lorry_no }}</span></td>
                            <td>
                                <div class="fw-semibold">{{ $lorry->owner_name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $lorry->owner_mobile ?? '' }}</small>
                            </td>
                            <td><strong>{{ $lorry->weight }} Tons</strong></td>
                            <td><span class="text-truncate d-inline-block" style="max-width: 180px;">{{ $lorry->curr_location }}</span></td>
                            <td>
                                @if($lorry->is_verify == 1)
                                    <span class="badge bg-success">Verified</span>
                                @elseif($lorry->is_verify == 2)
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($lorry->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.lorries.show', $lorry->id) }}" class="btn btn-outline-primary" title="View Lorry Details">
                                        <i data-feather="eye"></i> Details
                                    </a>
                                    <form action="{{ route('admin.lorries.toggleStatus', $lorry->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $lorry->status == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}" title="Toggle Status">
                                            <i data-feather="{{ $lorry->status == 1 ? 'power' : 'check' }}"></i>
                                        </button>
                                    </form>
                                </div>
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
