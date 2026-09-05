@extends('layouts.landing')

@section('title', ($setting->webname ?? 'Movers') . ' - Pakistan\'s #1 Digital Freight, Truck Booking & Logistics Platform')

@section('styles')
<style>
    /* Hero Section Styling */
    .hero-section {
        background: linear-gradient(135deg, #0B1120 0%, #1E1B4B 60%, #0F172A 100%);
        padding: 100px 0 130px 0;
        position: relative;
        overflow: hidden;
        color: #ffffff;
    }

    .hero-glow-1 {
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(79, 70, 229, 0.3) 0%, transparent 70%);
        top: -100px;
        left: -100px;
        border-radius: 50%;
        filter: blur(40px);
        pointer-events: none;
    }

    .hero-glow-2 {
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.22) 0%, transparent 70%);
        bottom: -150px;
        right: -100px;
        border-radius: 50%;
        filter: blur(50px);
        pointer-events: none;
    }

    .hero-badge {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 6px 16px;
        border-radius: 50px;
        color: #93C5FD;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 3.5rem;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 20px;
    }

    @media (max-width: 991px) {
        .hero-title { font-size: 2.5rem; }
    }

    .hero-subtitle {
        font-size: 1.15rem;
        line-height: 1.6;
        color: #CBD5E1;
        margin-bottom: 35px;
    }

    /* Hero Estimator Card */
    .hero-calculator-card {
        background: rgba(30, 41, 59, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* Counter Bar */
    .metrics-bar {
        background: #ffffff;
        margin-top: -60px;
        border-radius: 20px;
        box-shadow: 0 15px 35px -5px rgba(15, 23, 42, 0.1);
        border: 1px solid #E2E8F0;
        padding: 35px 20px;
        position: relative;
        z-index: 10;
    }

    .metric-item {
        text-align: center;
        padding: 10px 15px;
    }

    .metric-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0F172A;
        font-family: 'Outfit', sans-serif;
        line-height: 1;
        margin-bottom: 6px;
    }

    .metric-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Feature Tabs */
    .journey-tabs .nav-link {
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 700;
        font-size: 1.05rem;
        color: #475569 !important;
        background: #F1F5F9;
        border: 1px solid transparent;
        transition: all 0.3s;
    }

    .journey-tabs .nav-link.active {
        background: var(--primary);
        color: #ffffff !important;
        box-shadow: 0 8px 20px -3px rgba(79, 70, 229, 0.4);
    }

    .step-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 28px;
        height: 100%;
        position: relative;
        transition: all 0.3s;
    }

    .step-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px -5px rgba(15, 23, 42, 0.1);
        border-color: #CBD5E1;
    }

    .step-number {
        width: 44px;
        height: 44px;
        background: var(--primary-light);
        color: var(--primary);
        font-weight: 800;
        font-size: 1.2rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    /* Vehicle Fleet Cards */
    .fleet-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }

    .fleet-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -8px rgba(15, 23, 42, 0.12);
        border-color: var(--primary);
    }

    .fleet-img-wrapper {
        background: linear-gradient(135deg, #F8FAFC 0%, #EEF2FF 100%);
        padding: 25px;
        text-align: center;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fleet-img {
        max-height: 120px;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
    }

    /* Testimonial Cards */
    .testimonial-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
    }

    /* FAQ Section Accordion */
    .custom-accordion .accordion-item {
        border: 1px solid #E2E8F0;
        border-radius: 14px !important;
        margin-bottom: 14px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
    }

    .custom-accordion .accordion-button {
        font-weight: 700;
        font-size: 1.05rem;
        color: #0F172A;
        background: #ffffff;
        padding: 20px 24px;
    }

    .custom-accordion .accordion-button:not(.collapsed) {
        background-color: var(--primary-light);
        color: var(--primary);
        box-shadow: none;
    }

    .custom-accordion .accordion-body {
        padding: 20px 24px;
        color: #475569;
        line-height: 1.7;
    }

    /* App Download CTA Banner */
    .download-cta-banner {
        background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 100%);
        border-radius: 28px;
        padding: 60px 50px;
        position: relative;
        overflow: hidden;
        color: #ffffff;
    }
</style>
@endsection

@section('content')

<!-- 1. HERO SECTION -->
<section class="hero-section">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <!-- Left Hero Content -->
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill text-warning"></i>
                    <span>Pakistan's #1 Digital Lorry & Freight Network</span>
                </div>

                <h1 class="hero-title">
                    Smarter Freight Transport with <span class="gradient-text-light">Zero Brokerage</span>
                </h1>

                <p class="hero-subtitle">
                    Connect directly with <strong>10,000+ verified truck owners</strong> across Karachi, Lahore, Islamabad, Multan, and Peshawar. Get inDrive-style fair bidding, instant electronic Bilty, and real-time live GPS tracking.
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="{{ route('landing.download') }}" class="btn-brand-primary">
                        <i class="bi bi-download"></i> Download Movers App
                    </a>
                    <a href="{{ route('landing.calculator') }}" class="btn-brand-outline-light">
                        <i class="bi bi-calculator"></i> Calculate Trip Fare
                    </a>
                </div>

                <!-- Trust Points -->
                <div class="d-flex flex-wrap gap-4 pt-3 border-top border-secondary border-opacity-25 text-white-50 small">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill text-success fs-5"></i>
                        <span>100% KYC Verified Drivers</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-qr-code-scan text-info fs-5"></i>
                        <span>Digital Bilty & Adda Register</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-warning fs-5"></i>
                        <span>Live GPS Telematics</span>
                    </div>
                </div>
            </div>

            <!-- Right Hero Interactive Fare Calculator -->
            <div class="col-lg-6">
                <div class="hero-calculator-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="fs-4 text-white mb-1 brand-font"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Instant Fare Estimator</h3>
                            <p class="text-white-50 small mb-0">Check live distance, fuel consumption & fair truck rate</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 px-2 py-1 rounded-pill small">
                            Diesel: Rs. {{ number_format($setting->diesel_price ?? 275, 0) }}/L
                        </span>
                    </div>

                    <form id="heroFareForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label text-white-50 small fw-semibold">Pickup Hub (From)</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" id="heroFromCity" name="from_city" required>
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}" {{ $c == 'Karachi' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label text-white-50 small fw-semibold">Delivery Hub (To)</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" id="heroToCity" name="to_city" required>
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}" {{ $c == 'Lahore' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-8">
                                <label class="form-label text-white-50 small fw-semibold">Select Truck Type</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" id="heroVehicleId" name="vehicle_id" required>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ $v->title }} ({{ $v->min_weight }}-{{ $v->max_weight }} Ton)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label text-white-50 small fw-semibold">Payload (Tons)</label>
                                <input type="number" class="form-control bg-dark text-white border-secondary border-opacity-50 py-2" id="heroWeight" name="weight" value="5" min="1" max="100">
                            </div>

                            <div class="col-12">
                                <button type="button" id="btnCalculateHero" class="btn btn-brand-primary w-100 justify-content-center py-3 fs-6">
                                    <i class="bi bi-calculator-fill"></i> Calculate Fair Estimate
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Results Box (AJAX Updated) -->
                    <div id="heroCalcResult" class="mt-4 p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25" style="display: none;">
                        <div class="row text-center g-2">
                            <div class="col-4 border-end border-secondary border-opacity-25">
                                <span class="d-block text-white-50 small">Distance</span>
                                <strong class="text-info fs-6" id="resDistance">0 KM</strong>
                            </div>
                            <div class="col-4 border-end border-secondary border-opacity-25">
                                <span class="d-block text-white-50 small">Est. Time</span>
                                <strong class="text-warning fs-6" id="resTime">0 Hrs</strong>
                            </div>
                            <div class="col-4">
                                <span class="d-block text-white-50 small">Est. Freight Fare</span>
                                <strong class="text-success fs-5 fw-bold" id="resFare">Rs. 0</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. METRICS COUNTER BAR -->
<div class="container">
    <div class="metrics-bar">
        <div class="row g-4 align-items-center">
            <div class="col-md-3 col-6 border-end-md">
                <div class="metric-item">
                    <div class="metric-number text-primary">{{ number_format($counts['lorries']) }}+</div>
                    <div class="metric-label">Verified Lorries</div>
                </div>
            </div>
            <div class="col-md-3 col-6 border-end-md">
                <div class="metric-item">
                    <div class="metric-number text-success">{{ number_format($counts['shippers']) }}+</div>
                    <div class="metric-label">Active Shippers</div>
                </div>
            </div>
            <div class="col-md-3 col-6 border-end-md">
                <div class="metric-item">
                    <div class="metric-number text-indigo">{{ number_format($counts['loads']) }}+</div>
                    <div class="metric-label">Loads Delivered</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="metric-item">
                    <div class="metric-number text-warning">{{ $counts['cities'] }}+</div>
                    <div class="metric-label">Logistics Hubs</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. HOW IT WORKS (DUAL JOURNEY TABS) -->
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Streamlined Logistics</span>
            <h2 class="section-title">How Movers Works For You</h2>
            <p class="section-desc">Whether you are shipping bulk cargo across provinces or managing a fleet of trucks, Movers makes every shipment effortless and transparent.</p>
        </div>

        <!-- Journey Tabs -->
        <ul class="nav nav-pills journey-tabs justify-content-center gap-3 mb-5" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-shipper-tab" data-bs-toggle="pill" data-bs-target="#pills-shipper" type="button" role="tab" aria-controls="pills-shipper" aria-selected="true">
                    <i class="bi bi-box-seam me-2"></i> For Shippers & Cargo Owners
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-transporter-tab" data-bs-toggle="pill" data-bs-target="#pills-transporter" type="button" role="tab" aria-controls="pills-transporter" aria-selected="false">
                    <i class="bi bi-truck me-2"></i> For Transporters & Fleet Owners
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- Shipper Journey -->
            <div class="tab-pane fade show active" id="pills-shipper" role="tabpanel" aria-labelledby="pills-shipper-tab">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h4 class="fs-5 mb-2">Post Your Load</h4>
                            <p class="text-muted small mb-0">Enter pickup/drop locations, cargo weight, vehicle category, and your initial price offer in under 60 seconds.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h4 class="fs-5 mb-2">Compare Driver Bids</h4>
                            <p class="text-muted small mb-0">Receive competitive direct offers from verified lorry owners. Review driver ratings, past trips, and vehicle condition.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h4 class="fs-5 mb-2">Digital Bilty & Escrow</h4>
                            <p class="text-muted small mb-0">Accept the best bid, generate an official E-Bilty with QR verification, and secure payment in the Movers Escrow Wallet.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">4</div>
                            <h4 class="fs-5 mb-2">Live GPS & Delivery</h4>
                            <p class="text-muted small mb-0">Track driver route in real time. Driver submits electronic Proof of Delivery (POD) before payment is released.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transporter Journey -->
            <div class="tab-pane fade" id="pills-transporter" role="tabpanel" aria-labelledby="pills-transporter-tab">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h4 class="fs-5 mb-2">Register & Verify Lorry</h4>
                            <p class="text-muted small mb-0">Upload CNIC, driving license, and vehicle registration documents. Get approved quickly by our KYC team.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h4 class="fs-5 mb-2">Browse Live Loads</h4>
                            <p class="text-muted small mb-0">Find high-paying freight loads in your city or along your return route with zero empty return miles.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h4 class="fs-5 mb-2">Submit Your Price Bid</h4>
                            <p class="text-muted small mb-0">Set your own rate with transparent inDrive-style bidding without middleman brokerage fees.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="step-card">
                            <div class="step-number">4</div>
                            <h4 class="fs-5 mb-2">Instant Bank Payout</h4>
                            <p class="text-muted small mb-0">Complete the trip, submit digital delivery receipt, and withdraw earnings directly to your bank account or wallet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. FLEET & VEHICLE SHOWCASE -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Nationwide Fleet Directory</span>
            <h2 class="section-title">Vehicles for Every Cargo Size</h2>
            <p class="section-desc">From light urban pickups to heavy multi-axle trailers, our verified fleet is ready to dispatch anywhere in Pakistan.</p>
        </div>

        <div class="row g-4">
            @foreach($vehicles->take(8) as $veh)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="fleet-card">
                        <div class="fleet-img-wrapper">
                            @if(!empty($veh->img) && file_exists(public_path($veh->img)))
                                <img src="{{ asset($veh->img) }}" alt="{{ $veh->title }}" class="fleet-img">
                            @else
                                <div class="text-primary fs-1"><i class="fa-solid fa-truck"></i></div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="fs-6 fw-bold mb-0 text-dark">{{ $veh->title }}</h4>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">{{ $veh->min_weight }}-{{ $veh->max_weight }} Tons</span>
                            </div>
                            <div class="border-top border-light pt-3 mt-3 text-muted small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Base Fare:</span>
                                    <strong class="text-dark">Rs. {{ number_format($veh->base_fare ?? 1500) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Rate per KM:</span>
                                    <strong class="text-dark">Rs. {{ number_format($veh->per_km_rate ?? 75) }} / km</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Fuel Avg:</span>
                                    <strong class="text-dark">{{ $veh->fuel_average ?? 6 }} KM/L</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('landing.calculator') }}" class="btn btn-brand-primary">
                <i class="bi bi-speedometer2"></i> Explore All Vehicles & Calculate Rates
            </a>
        </div>
    </div>
</section>

<!-- 5. KEY ADVANTAGES & DIGITAL BILTY -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Why Choose Movers</span>
                <h2 class="section-title mb-4">Eliminating Brokers. Delivering Transparency.</h2>
                <p class="text-muted mb-4">
                    Traditional goods transport in Pakistan suffers from hidden agent commissions, untracked routes, paper bilty forgery, and delayed payments. Movers solves all four with cutting-edge logistics technology.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 fs-4">
                                    <i class="bi bi-tag-fill"></i>
                                </div>
                                <h5 class="fs-6 fw-bold mb-0">Zero Brokerage</h5>
                            </div>
                            <p class="text-muted small mb-0">Direct shipper-to-driver bargaining saves up to 20% on freight costs.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="bg-success bg-opacity-10 text-success p-2 rounded-3 fs-4">
                                    <i class="bi bi-file-earmark-check-fill"></i>
                                </div>
                                <h5 class="fs-6 fw-bold mb-0">Electronic Bilty</h5>
                            </div>
                            <p class="text-muted small mb-0">Instant QR-coded legal bilty for checkpoint clearances and invoicing.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="bg-info bg-opacity-10 text-info p-2 rounded-3 fs-4">
                                    <i class="bi bi-pin-map-fill"></i>
                                </div>
                                <h5 class="fs-6 fw-bold mb-0">Live GPS Tracking</h5>
                            </div>
                            <p class="text-muted small mb-0">Track shipment milestones and driver location from dispatch to delivery.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 border rounded-3 bg-white shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-3 fs-4">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <h5 class="fs-6 fw-bold mb-0">Secure Escrow</h5>
                            </div>
                            <p class="text-muted small mb-0">Funds held safely in escrow and released only upon delivery confirmation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 bg-dark text-white position-relative shadow-lg border border-secondary border-opacity-25">
                    <div class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill mb-3">
                        <i class="bi bi-patch-check-fill me-1"></i> Digital Innovation
                    </div>
                    <h3 class="brand-font text-white mb-3">Movers Adda & Community Hub</h3>
                    <p class="text-white-50 mb-4">
                        We connect traditional transport Addas (Badami Bagh Lahore, Mauripur Karachi, Pirwadhai Rawalpindi) directly to the cloud. Over 50+ regional community chat groups keep drivers updated on route closures, tolls, and cargo opportunities.
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10">
                            <i class="bi bi-chat-dots-fill fs-3 text-info"></i>
                            <div>
                                <strong class="d-block text-white">Live Adda Broadcasts</strong>
                                <span class="text-white-50 small">Get notified of road blockages, fog advisories & return loads.</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10">
                            <i class="bi bi-shield-shaded fs-3 text-warning"></i>
                            <div>
                                <strong class="d-block text-white">24/7 Roadside Assistance & Helpline</strong>
                                <span class="text-white-50 small">Dedicated emergency dispatch team across national highways.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. SHIPPER & DRIVER TESTIMONIALS -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Real Stories</span>
            <h2 class="section-title">Trusted by Shippers & Drivers</h2>
            <p class="section-desc">See how Movers has transformed the way Pakistan moves bulk cargo, textiles, produce, and consumer goods.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">
                            TA
                        </div>
                        <div>
                            <h5 class="fs-6 mb-0 fw-bold">Tariq Ansari</h5>
                            <span class="text-muted small">Textile Mill Owner, Faisalabad</span>
                        </div>
                    </div>
                    <div class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted small mb-0">
                        "We dispatch 20+ containers weekly from Faisalabad to Karachi port. Movers eliminated the middle brokers and cut our freight costs by 18%. The digital bilty saves countless hours at port gates."
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">
                            MK
                        </div>
                        <div>
                            <h5 class="fs-6 mb-0 fw-bold">Malik Kamran</h5>
                            <span class="text-muted small">Fleet Owner (8 Trailers), Rawalpindi</span>
                        </div>
                    </div>
                    <div class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted small mb-0">
                        "Our trucks used to wait 2-3 days in Karachi for return loads. With the Movers app, my drivers get return freight offers before they even finish unloading. Zero idle downtime!"
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-indigo text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px; background-color: #6366F1;">
                            SZ
                        </div>
                        <div>
                            <h5 class="fs-6 mb-0 fw-bold">Shahzad Zia</h5>
                            <span class="text-muted small">Agri Commodities Shipper, Multan</span>
                        </div>
                    </div>
                    <div class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted small mb-0">
                        "When shipping perishable fruits and vegetables, punctuality is everything. Live GPS tracking allows our warehouse team to plan loading and unloading down to the exact minute."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. FAQ ACCORDION -->
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">Everything you need to know about load booking, transporter bidding, KYC verification, and digital bilty.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion custom-accordion" id="landingFaqAccordion">
                    @forelse($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#landingFaqAccordion">
                                <div class="accordion-body">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    How does the inDrive-style driver bidding work?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#landingFaqAccordion">
                                <div class="accordion-body">
                                    When you post a load, verified truck drivers and fleet owners receive an instant alert. They submit competitive bids. You can accept the best offer based on price, driver rating, and vehicle specifications.
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">Have more questions? Visit our <a href="{{ route('landing.faq') }}" class="text-primary fw-semibold">Complete Help Center</a> or <a href="{{ route('landing.contact') }}" class="text-primary fw-semibold">Contact Support</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. APP DOWNLOAD CALL TO ACTION BANNER -->
<section class="section-padding pt-0">
    <div class="container">
        <div class="download-cta-banner">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-3">
                        <i class="bi bi-stars me-1"></i> Available on Android & iOS
                    </div>
                    <h2 class="text-white fs-1 mb-3 brand-font">Ready to Transform Your Freight Operations?</h2>
                    <p class="text-white-50 fs-5 mb-4">
                        Download the Movers app today. Post loads in seconds, receive verified driver bids, and manage nationwide dispatches with complete peace of mind.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('landing.download') }}" class="btn btn-warning text-dark fw-bold py-3 px-4 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-google-play fs-5"></i> Download for Android
                        </a>
                        <a href="{{ route('landing.download') }}" class="btn btn-outline-light fw-bold py-3 px-4 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-apple fs-5"></i> Download for iOS
                        </a>
                        <a href="{{ route('landing.calculator') }}" class="btn btn-dark border border-secondary border-opacity-50 text-white fw-bold py-3 px-4 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-calculator"></i> Try Web Calculator
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-10 d-inline-block text-center">
                        <i class="bi bi-qr-code text-white fs-1 d-block mb-2"></i>
                        <span class="text-white fw-semibold small">Scan to Install App</span>
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
        const btnCalc = document.getElementById('btnCalculateHero');
        if (btnCalc) {
            btnCalc.addEventListener('click', function () {
                const fromCity = document.getElementById('heroFromCity').value;
                const toCity = document.getElementById('heroToCity').value;
                const vehicleId = document.getElementById('heroVehicleId').value;
                const weight = document.getElementById('heroWeight').value;

                btnCalc.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Calculating...';
                btnCalc.disabled = true;

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
                    btnCalc.innerHTML = '<i class="bi bi-calculator-fill"></i> Calculate Fair Estimate';
                    btnCalc.disabled = false;

                    if (data.success) {
                        const d = data.data;
                        document.getElementById('resDistance').textContent = d.distance_km + ' KM';
                        document.getElementById('resTime').textContent = '~' + d.estimated_hours + ' hrs';
                        document.getElementById('resFare').textContent = 'Rs. ' + d.total_fare.toLocaleString();
                        document.getElementById('heroCalcResult').style.display = 'block';
                    } else {
                        alert(data.message || 'Error calculating fare');
                    }
                })
                .catch(err => {
                    btnCalc.innerHTML = '<i class="bi bi-calculator-fill"></i> Calculate Fair Estimate';
                    btnCalc.disabled = false;
                    console.error(err);
                });
            });
        }
    });
</script>
@endsection
