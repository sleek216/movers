@extends('admin.layouts.app')

@section('title', 'Earning Reports')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Platform Earning Report</h4>
                <p class="text-muted mb-0">Commission revenue generated from completed loads</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.payouts.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-feather="arrow-left"></i> Back to Payouts
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Earning Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="f-14 text-white-50">Total Admin Platform Commission</span>
                            <h2 class="fw-bold mb-0 text-white mt-1">${{ number_format($totalEarnings, 2) }}</h2>
                        </div>
                        <i data-feather="dollar-sign" style="width: 48px; height: 48px; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="f-14 text-white-50">Total Gross Freight Volume (Completed)</span>
                            <h2 class="fw-bold mb-0 text-white mt-1">${{ number_format($totalVolume, 2) }}</h2>
                        </div>
                        <i data-feather="package" style="width: 48px; height: 48px; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Deliveries Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">Completed Consignments Breakdown</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#Load ID</th>
                            <th>Customer</th>
                            <th>Transporter</th>
                            <th>Completed Date</th>
                            <th>Consignment Value</th>
                            <th>Platform Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedLoads as $load)
                        <tr>
                            <td><strong>#{{ $load->id }}</strong></td>
                            <td>{{ $load->customer_name ?? 'User #' . $load->uid }}</td>
                            <td>{{ $load->transporter_name ?? 'Owner #' . $load->lorry_owner_id }}</td>
                            <td><small class="text-muted">{{ $load->post_date }}</small></td>
                            <td><strong>${{ number_format($load->total_amt ?? $load->amount, 2) }}</strong></td>
                            <td><strong class="text-success">${{ number_format($load->commission, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
