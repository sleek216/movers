@extends('admin.layouts.app')

@section('title', 'Digital Bilty & Adda Register')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">📄 Digital Bilty & Adda Register</h4>
                <p class="text-muted mb-0">Consignment notes, freight details, Driver KYC & Guarantor records</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Counter -->
<div class="container-fluid mb-4">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small">Total Bilties</span>
                        <h3 class="mb-0 fw-bold">{{ $totalCount }}</h3>
                    </div>
                    <i class="fas fa-file-invoice fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-black-50 small">Booked (At Adda)</span>
                        <h3 class="mb-0 fw-bold">{{ $bookedCount }}</h3>
                    </div>
                    <i class="fas fa-warehouse fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small">In-Transit (On Road)</span>
                        <h3 class="mb-0 fw-bold">{{ $inTransitCount }}</h3>
                    </div>
                    <i class="fas fa-truck-moving fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small">Delivered (Completed)</span>
                        <h3 class="mb-0 fw-bold">{{ $deliveredCount }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="container-fluid">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.bilties.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search by Bilty #, Sender, Receiver, Driver, Truck, or CNIC..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All Statuses</option>
                        <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                        <option value="In-Transit" {{ request('status') == 'In-Transit' ? 'selected' : '' }}>In-Transit</option>
                        <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.bilties.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bilties Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Bilty #</th>
                            <th>Date</th>
                            <th>Route (From ➔ To)</th>
                            <th>Sender & Receiver</th>
                            <th>Cargo / Goods</th>
                            <th>Freight (Kiraya)</th>
                            <th>Driver & Vehicle</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bilties as $bilty)
                        <tr>
                            <td class="ps-3">
                                <span class="badge bg-dark font-monospace fs-6">{{ $bilty->bilty_number }}</span>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $bilty->bilty_date ? $bilty->bilty_date->format('d M, Y') : $bilty->created_at->format('d M, Y') }}</div>
                                <div class="text-muted small">{{ $bilty->created_at->format('h:i A') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $bilty->consignor_city }} ➔ {{ $bilty->consignee_city }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">From: {{ $bilty->consignor_name }} <span class="text-muted small">({{ $bilty->consignor_phone }})</span></div>
                                <div class="fw-semibold text-secondary">To: {{ $bilty->consignee_name }} <span class="text-muted small">({{ $bilty->consignee_phone }})</span></div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $bilty->goods_description }}</div>
                                <div class="text-muted small">{{ $bilty->total_packages }} {{ $bilty->package_type }} • {{ $bilty->weight_value }} {{ $bilty->weight_unit }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-success">Rs. {{ number_format($bilty->freight_total) }}</div>
                                <div class="small text-muted">Adv: Rs. {{ number_format($bilty->advance_paid) }} | Baqi: Rs. {{ number_format($bilty->balance_amount) }}</div>
                                <span class="badge {{ $bilty->payment_status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $bilty->payment_status }}</span>
                            </td>
                            <td>
                                @if($bilty->driver_name)
                                    <div class="fw-semibold">{{ $bilty->driver_name }}</div>
                                    <div class="text-muted small">Truck: <span class="badge bg-secondary">{{ $bilty->truck_number }}</span></div>
                                    @if($bilty->guarantor_name)
                                        <div class="small text-primary"><i class="fas fa-shield-alt me-1"></i>Zamanat: {{ $bilty->guarantor_name }}</div>
                                    @endif
                                @else
                                    <span class="text-muted small">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                @if($bilty->status == 'Delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($bilty->status == 'In-Transit')
                                    <span class="badge bg-info">In-Transit</span>
                                @else
                                    <span class="badge bg-warning text-dark">Booked</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.bilties.show', $bilty->id) }}" class="btn btn-sm btn-outline-primary me-1" title="View KYC & Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.bilties.print', $bilty->id) }}" target="_blank" class="btn btn-sm btn-outline-dark me-1" title="Print Bilty">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('admin.bilties.destroy', $bilty->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this bilty?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-file-invoice fa-3x mb-3 text-secondary"></i>
                                <p class="mb-0">No digital bilties found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top">
                {{ $bilties->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
