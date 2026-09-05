@extends('admin.layouts.app')

@section('title', 'Route Calculator & Rates')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--text-main);">🛣️ Route & Freight Rate Settings</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Route Calculator</li>
                </ol>
            </nav>
        </div>
        <div>
            <button type="submit" form="calculatorRatesForm" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                <i class="bi bi-check2-circle me-1"></i> Save All Rates
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stat Widgets & Diesel Reference -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Current Diesel Reference</div>
                        <div class="stat-value text-primary">Rs. {{ number_format($dieselPrice, 2) }} / L</div>
                    </div>
                    <div class="stat-icon primary">
                        <i class="bi bi-fuel-pump-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Configured Vehicles</div>
                        <div class="stat-value">{{ count($vehicles) }} Types</div>
                    </div>
                    <div class="stat-icon info">
                        <i class="bi bi-truck-front-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Avg. Heavy Per-KM Rate</div>
                        <div class="stat-value text-success">Rs. 185 / KM</div>
                    </div>
                    <div class="stat-icon success">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Toll Tax Calculation</div>
                        <div class="stat-value text-warning">Dynamic per KM</div>
                    </div>
                    <div class="stat-icon warning">
                        <i class="bi bi-signpost-2-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Rates Configuration Form -->
    <form id="calculatorRatesForm" action="{{ route('admin.calculator.update') }}" method="POST">
        @csrf

        <!-- Diesel Rate Setting Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-3 bg-primary-subtle text-primary fs-4">
                                <i class="bi bi-fuel-pump-diesel"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Standard Diesel Reference Price</h6>
                                <small class="text-muted">Used by the mobile app to show estimated fuel cost share for long-haul routes.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <div class="input-group ms-auto" style="max-width: 260px;">
                            <span class="input-group-text bg-light fw-bold">Rs.</span>
                            <input type="number" step="0.5" name="diesel_price" class="form-control fw-bold text-primary fs-5 text-center" value="{{ $dieselPrice }}" required>
                            <span class="input-group-text bg-light text-muted">/ Litre</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Rates Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold">Vehicle Types Pricing Matrix</h5>
                    <small class="text-muted">Set base booking fare, per-kilometer rate, highway toll factor, and average fuel mileage for each vehicle category.</small>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 25%;">Vehicle Type</th>
                                <th style="width: 18%;">Base Booking Fare</th>
                                <th style="width: 18%;">Per KM Rate</th>
                                <th style="width: 18%;">Toll Rate / KM</th>
                                <th class="pe-4" style="width: 21%;">Fuel Mileage (KM/L)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if(!empty($vehicle->img) && file_exists(public_path($vehicle->img)))
                                                <img src="{{ asset($vehicle->img) }}" alt="{{ $vehicle->title }}" class="rounded shadow-sm" style="width: 44px; height: 32px; object-fit: contain;">
                                            @else
                                                <div class="rounded d-flex align-items-center justify-content-center fw-bold bg-light text-primary" style="width: 44px; height: 32px;">
                                                    <i class="bi bi-truck"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $vehicle->title }}</div>
                                                <small class="text-muted">{{ $vehicle->min_weight }} - {{ $vehicle->max_weight }} Tons</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light text-muted">Rs.</span>
                                            <input type="number" step="50" name="vehicles[{{ $vehicle->id }}][base_fare]" class="form-control fw-bold" value="{{ $vehicle->base_fare }}" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light text-muted">Rs.</span>
                                            <input type="number" step="1" name="vehicles[{{ $vehicle->id }}][per_km_rate]" class="form-control fw-bold text-primary" value="{{ $vehicle->per_km_rate }}" required>
                                            <span class="input-group-text bg-light text-muted">/KM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light text-muted">Rs.</span>
                                            <input type="number" step="0.5" name="vehicles[{{ $vehicle->id }}][toll_rate_per_km]" class="form-control fw-semibold" value="{{ $vehicle->toll_rate_per_km }}" required>
                                            <span class="input-group-text bg-light text-muted">/KM</span>
                                        </div>
                                    </td>
                                    <td class="pe-4">
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" name="vehicles[{{ $vehicle->id }}][fuel_average]" class="form-control fw-semibold text-center" value="{{ $vehicle->fuel_average }}" required>
                                            <span class="input-group-text bg-light text-muted">KM / Litre</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-light py-3 text-end pe-4">
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
