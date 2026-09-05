@extends('layouts.landing')

@section('title', 'Live Freight & Fare Estimator - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Calculate instant, accurate truck freight rates between all major cities across Pakistan. Includes fuel indexing, road distance, highway tolls, and vehicle tonnage.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-calculator-fill"></i> Real-Time Fare Matrix</span>
                <h1 class="text-white fs-1 mb-2">Freight Rate & Trip Estimator</h1>
                <p class="text-white-50 fs-6 mb-0">Transparent calculations based on live diesel pricing, motorway tolls, and vehicle capacities.</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">Fare Calculator</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <div class="p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 d-inline-block text-start">
                    <span class="d-block text-white-50 small">Live Diesel Index</span>
                    <strong class="fs-4 text-warning">Rs. {{ number_format($setting->diesel_price ?? 275, 2) }}/L</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculator App Section -->
<section class="section-padding bg-body">
    <div class="container">
        <div class="row g-5">
            <!-- Left Side: Input Form -->
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                    <h3 class="fs-4 text-dark fw-bold mb-1"><i class="bi bi-sliders text-primary me-2"></i>Trip & Cargo Parameters</h3>
                    <p class="text-muted small mb-4">Select route hubs and vehicle specifications to calculate instant estimates.</p>

                    <form id="mainCalcForm">
                        @csrf
                        <div class="row g-4">
                            <!-- Origin -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Loading City (Origin)</label>
                                <select class="form-select form-select-lg fs-6" id="calcFromCity" name="from_city" required>
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}" {{ $c == 'Karachi' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Destination -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small"><i class="bi bi-pin-map-fill text-success me-1"></i> Unloading City (Destination)</label>
                                <select class="form-select form-select-lg fs-6" id="calcToCity" name="to_city" required>
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}" {{ $c == 'Lahore' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Vehicle Picker -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small"><i class="bi bi-truck text-primary me-1"></i> Vehicle Category</label>
                                <select class="form-select form-select-lg fs-6" id="calcVehicleId" name="vehicle_id" required>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}" 
                                                data-base="{{ $v->base_fare }}" 
                                                data-rate="{{ $v->per_km_rate }}" 
                                                data-fuel="{{ $v->fuel_average }}" 
                                                data-min="{{ $v->min_weight }}" 
                                                data-max="{{ $v->max_weight }}"
                                                {{ $loop->first ? 'selected' : '' }}>
                                            {{ $v->title }} &nbsp;|&nbsp; Capacity: {{ $v->min_weight }}-{{ $v->max_weight }} Tons &nbsp;|&nbsp; Rate: Rs. {{ number_format($v->per_km_rate) }}/km
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cargo Weight -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small"><i class="bi bi-speedometer2 text-info me-1"></i> Estimated Cargo Weight (Tons)</label>
                                <input type="number" class="form-control form-control-lg fs-6" id="calcWeight" name="weight" value="10" min="1" max="100" step="0.5">
                            </div>

                            <!-- Material Type (Optional context) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small"><i class="bi bi-box-seam text-secondary me-1"></i> Material Type</label>
                                <select class="form-select form-select-lg fs-6" id="calcMaterial">
                                    <option value="General Cargo">General Industrial Cargo</option>
                                    <option value="Textile & Fabrics">Textile, Yarn & Garments</option>
                                    <option value="Agriculture / Grain">Agriculture, Wheat, Rice, Cotton</option>
                                    <option value="Perishable Produce">Perishable Produce / Cold Chain</option>
                                    <option value="Construction & Steel">Construction, Cement & Steel</option>
                                    <option value="Machinery">Industrial Heavy Machinery</option>
                                </select>
                            </div>

                            <!-- Action Button -->
                            <div class="col-12">
                                <button type="button" id="btnMainCalculate" class="btn btn-brand-primary w-100 py-3 fs-5 justify-content-center">
                                    <i class="bi bi-calculator-fill"></i> Calculate Route & Fare
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side: Calculation Results Card -->
            <div class="col-lg-5">
                <div class="glass-card p-4 p-md-5 sticky-top" style="top: 100px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fs-5 text-dark fw-bold mb-0">Estimated Cost Breakdown</h4>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i> Live Accurate
                        </span>
                    </div>

                    <div id="calcLoadingSpinner" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted small mt-2">Computing highway distance & rates...</p>
                    </div>

                    <div id="calcResultsDisplay">
                        <!-- Key Fare Box -->
                        <div class="p-4 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 mb-4 text-center">
                            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Recommended Fair Rate</span>
                            <h2 class="display-6 fw-bold text-primary my-2 brand-font" id="displayTotalFare">Rs. 95,000</h2>
                            <span class="badge bg-primary text-white small px-3 py-1 rounded-pill" id="displayRouteLabel">Karachi → Lahore</span>
                        </div>

                        <!-- Breakdown List -->
                        <ul class="list-group list-group-flush small mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="bi bi-signpost-2 text-primary me-2"></i>Total Highway Distance:</span>
                                <strong class="text-dark" id="displayDistance">1,210 KM</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="bi bi-clock-history text-warning me-2"></i>Estimated Driving Time:</span>
                                <strong class="text-dark" id="displayTime">~24.2 Hours</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="bi bi-cash text-success me-2"></i>Base Loading Fare:</span>
                                <strong class="text-dark" id="displayBaseFare">Rs. 4,000</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="bi bi-fuel-pump text-danger me-2"></i>Estimated Fuel Cost:</span>
                                <strong class="text-dark" id="displayFuelCost">Rs. 51,560 (187 L)</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="bi bi-ticket-perforated text-info me-2"></i>Motorway & Highway Tolls:</span>
                                <strong class="text-dark" id="displayTolls">Rs. 7,260</strong>
                            </li>
                        </ul>

                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('landing.download') }}" class="btn btn-brand-primary w-100 justify-content-center py-2">
                                <i class="bi bi-box-arrow-in-right"></i> Post This Load in App
                            </a>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                <i class="bi bi-printer"></i> Print Cost Summary
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnCalc = document.getElementById('btnMainCalculate');

        function runCalculation() {
            const fromCity = document.getElementById('calcFromCity').value;
            const toCity = document.getElementById('calcToCity').value;
            const vehicleId = document.getElementById('calcVehicleId').value;
            const weight = document.getElementById('calcWeight').value;

            document.getElementById('calcLoadingSpinner').style.display = 'block';
            document.getElementById('calcResultsDisplay').style.opacity = '0.4';

            fetch("{{ route('landing.calculateFare') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    from_city: fromCity,
                    to_city: toCity,
                    vehicle_id: vehicleId,
                    weight: weight
                })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('calcLoadingSpinner').style.display = 'none';
                document.getElementById('calcResultsDisplay').style.opacity = '1';

                if (data.success) {
                    const d = data.data;
                    document.getElementById('displayTotalFare').textContent = 'Rs. ' + d.total_fare.toLocaleString();
                    document.getElementById('displayRouteLabel').textContent = d.from_city + ' → ' + d.to_city;
                    document.getElementById('displayDistance').textContent = d.distance_km.toLocaleString() + ' KM';
                    document.getElementById('displayTime').textContent = '~' + d.estimated_hours + ' Hours';
                    document.getElementById('displayBaseFare').textContent = 'Rs. ' + d.base_fare.toLocaleString();
                    document.getElementById('displayFuelCost').textContent = 'Rs. ' + d.fuel_cost.toLocaleString() + ' (' + d.fuel_liters + ' L)';
                    document.getElementById('displayTolls').textContent = 'Rs. ' + d.toll_charge.toLocaleString();
                }
            })
            .catch(err => {
                document.getElementById('calcLoadingSpinner').style.display = 'none';
                document.getElementById('calcResultsDisplay').style.opacity = '1';
                console.error(err);
            });
        }

        if (btnCalc) {
            btnCalc.addEventListener('click', runCalculation);
            // Run initial calculate on load
            runCalculation();
        }
    });
</script>
@endsection
