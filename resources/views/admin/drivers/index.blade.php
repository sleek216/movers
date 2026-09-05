@extends('admin.layouts.app')

@section('title', 'Drivers List')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--text-main);">🚚 Drivers List</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Drivers</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-primary px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addDriverModal">
                <i class="bi bi-plus-lg me-1"></i> Add New Driver
            </button>
        </div>
    </div>

    <!-- Stat Widgets -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Total Drivers</div>
                        <div class="stat-value">{{ number_format($totalDrivers) }}</div>
                    </div>
                    <div class="stat-icon primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Active Drivers</div>
                        <div class="stat-value text-success">{{ number_format($activeDrivers) }}</div>
                    </div>
                    <div class="stat-icon success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Transporters / Owners</div>
                        <div class="stat-value text-info">{{ number_format($totalTransporters) }}</div>
                    </div>
                    <div class="stat-icon info">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table Card -->
    <div class="card">
        <div class="card-header bg-transparent d-flex flex-wrap align-items-center justify-content-between gap-3 py-3">
            <h5 class="mb-0 fw-bold">All Drivers ({{ $drivers->total() }})</h5>
            
            <form action="{{ route('admin.drivers.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width: 280px;">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 bg-light" placeholder="Search by name, route, or phone..." value="{{ $search }}">
                </div>

                <select name="transporter_id" class="form-select bg-light" style="max-width: 220px;" onchange="this.form.submit()">
                    <option value="">All Transporters</option>
                    @foreach($transporters as $transporter)
                        <option value="{{ $transporter->id }}" {{ $transporterId == $transporter->id ? 'selected' : '' }}>
                            {{ $transporter->name }} ({{ $transporter->mobile }})
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-outline-primary fw-semibold">Search</button>
                @if(!empty($search) || !empty($transporterId))
                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Driver</th>
                            <th>Phone Number</th>
                            <th>Route</th>
                            <th>Transporter / Owner</th>
                            <th>Date Added</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($drivers as $driver)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if(!empty($driver->photo) && file_exists(public_path($driver->photo)))
                                            <img src="{{ asset($driver->photo) }}" alt="{{ $driver->name }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 44px; height: 44px; border: 2px solid #E2E8F0;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 44px; height: 44px; background: #EEF2FF; color: #4F46E5; font-size: 1.1rem; border: 2px solid #E2E8F0;">
                                                {{ strtoupper(substr($driver->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $driver->name }}</div>
                                            <small class="text-muted">ID: #DRV-{{ $driver->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-semibold">{{ $driver->phone }}</span>
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $driver->phone);
                                            if (str_starts_with($cleanPhone, '0')) {
                                                $cleanPhone = '92' . substr($cleanPhone, 1);
                                            }
                                        @endphp
                                        <a href="tel:{{ $driver->phone }}" class="btn btn-sm btn-outline-primary p-1 py-0 rounded-circle" title="Call Driver" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-telephone-fill"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 rounded-pill fw-bold">
                                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $driver->primary_route ?: 'General Route' }}
                                    </span>
                                </td>
                                <td>
                                    @if(!empty($driver->transporter_name))
                                        <div>
                                            <a href="{{ route('admin.users.index') }}?search={{ urlencode($driver->transporter_name) }}" class="fw-bold text-primary text-decoration-none">
                                                {{ $driver->transporter_name }}
                                            </a>
                                            <div class="small text-muted">{{ $driver->transporter_mobile }}</div>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">None</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-dark">{{ \Carbon\Carbon::parse($driver->created_at)->format('d M Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($driver->created_at)->format('h:i A') }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDriverModal{{ $driver->id }}" title="Edit Driver">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove driver {{ $driver->name }}?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Driver">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Driver Modal -->
                                    <div class="modal fade" id="editDriverModal{{ $driver->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg text-start">
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title fw-bold">Edit Driver: {{ $driver->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body p-4">
                                                        <div class="mb-3 text-center">
                                                            @if(!empty($driver->photo) && file_exists(public_path($driver->photo)))
                                                                <img src="{{ asset($driver->photo) }}" class="rounded-circle mb-2" style="width: 72px; height: 72px; object-fit: cover; border: 3px solid #4F46E5;">
                                                            @endif
                                                            <div>
                                                                <label class="form-label fw-bold small">Change Photo (Optional)</label>
                                                                <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Driver Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $driver->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                                                            <input type="text" name="phone" class="form-control" value="{{ $driver->phone }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Route <span class="text-danger">*</span></label>
                                                            <input type="text" name="primary_route" class="form-control" value="{{ $driver->primary_route }}" placeholder="e.g. Lahore to Karachi" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary fw-bold px-4">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                        <div class="fw-bold fs-6">No drivers found</div>
                                        <small>Drivers added by transporters in the app will show up here.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($drivers->hasPages())
            <div class="card-footer bg-transparent py-3">
                {{ $drivers->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Add New Driver Modal -->
<div class="modal fade" id="addDriverModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Add New Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Transporter / Owner <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Choose Transporter Account</option>
                            @foreach($transporters as $transporter)
                                <option value="{{ $transporter->id }}">{{ $transporter->name }} ({{ $transporter->mobile }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Driver Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Tariq Khan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="e.g. 03001234567" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Route <span class="text-danger">*</span></label>
                        <input type="text" name="primary_route" class="form-control" placeholder="e.g. Lahore to Karachi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Driver Photo (Optional)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Save Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
