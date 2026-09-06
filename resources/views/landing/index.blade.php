@extends('layouts.landing')

@section('title', ($setting->webname ?? 'Movers') . ' - Digital Freight & Truck Booking Platform in Pakistan')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(145deg, #0F172A 0%, #1E293B 100%);
        padding: 80px 0 100px 0;
        position: relative;
        color: #ffffff;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #94A3B8;
        margin-bottom: 20px;
    }

    .hero-title {
        font-size: 3.25rem;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 18px;
        color: #F8FAFC;
    }

    @media (max-width: 991px) {
        .hero-title { font-size: 2.25rem; }
    }

    .hero-subtitle {
        font-size: 1.1rem;
        line-height: 1.65;
        color: #94A3B8;
        margin-bottom: 30px;
    }

    .hero-trust-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #CBD5E1;
        font-size: 0.9rem;
    }

    .hero-trust-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Calculator Card */
    .hero-calculator-card {
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
    }

    /* Feature Grid Cards */
    .feature-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 30px 24px;
        height: 100%;
        transition: all 0.25s ease-in-out;
        display: flex;
        flex-direction: column;
    }

    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.08);
        border-color: #CBD5E1;
    }

    .feature-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #F1F5F9;
        color: #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 20px;
    }

    .feature-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 10px;
    }

    .feature-desc {
        color: #64748B;
        font-size: 0.92rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Workflow Steps */
    .workflow-tabs .nav-link {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.95rem;
        color: #475569;
        background: #F1F5F9;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .workflow-tabs .nav-link.active {
        background: var(--primary);
        color: #ffffff;
    }

    .step-box {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 24px;
        height: 100%;
        position: relative;
    }

    .step-index {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #0F172A;
        color: #ffffff;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        margin-bottom: 16px;
    }

    /* Fleet Cards */
    .fleet-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        transition: all 0.25s ease;
    }

    .fleet-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }

    .fleet-img-wrap {
        height: 160px;
        background: #F8FAFC;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #F1F5F9;
        padding: 16px;
    }

    .fleet-img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* App Banner */
    .app-banner {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border-radius: 24px;
        padding: 48px 40px;
        color: #ffffff;
    }

    /* Custom Accordion */
    .custom-accordion .accordion-item {
        border: 1px solid #E2E8F0;
        border-radius: 12px !important;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .custom-accordion .accordion-button {
        font-weight: 600;
        font-size: 1rem;
        color: #0F172A;
        background: #ffffff;
        padding: 18px 22px;
    }

    .custom-accordion .accordion-button:not(.collapsed) {
        background-color: #F8FAFC;
        color: var(--primary);
        box-shadow: none;
    }

    .custom-accordion .accordion-body {
        padding: 18px 22px;
        color: #64748B;
        line-height: 1.65;
        font-size: 0.95rem;
    }
</style>
@endsection

@section('content')

<!-- 1. HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Left Hero Content -->
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="bi bi-truck text-light"></i>
                    <span>Digital Freight Logistics Platform</span>
                </div>

                <h1 class="hero-title">
                    Transparent Freight & Direct Truck Booking
                </h1>

                <p class="hero-subtitle">
                    Post your cargo loads, receive direct bids from verified truck drivers across Pakistan, and generate official electronic Bilty in minutes — with zero middleman commissions.
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="{{ route('landing.download') }}" class="btn btn-primary py-3 px-4 fw-semibold rounded-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-phone"></i> Download Mobile App
                    </a>
                    <a href="{{ route('landing.calculator') }}" class="btn btn-outline-light py-3 px-4 fw-semibold rounded-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-calculator"></i> Fare Calculator
                    </a>
                </div>

                <!-- Grounded Trust Points -->
                <div class="hero-trust-list">
                    <div class="hero-trust-item">
                        <i class="bi bi-check2-circle text-primary fs-5"></i>
                        <span>KYC Verified Drivers</span>
                    </div>
                    <div class="hero-trust-item">
                        <i class="bi bi-check2-circle text-primary fs-5"></i>
                        <span>Digital E-Bilty with QR</span>
                    </div>
                    <div class="hero-trust-item">
                        <i class="bi bi-check2-circle text-primary fs-5"></i>
                        <span>Direct Rate Bidding</span>
                    </div>
                </div>
            </div>

            <!-- Right Hero Interactive Fare Calculator -->
            <div class="col-lg-6">
                <div class="hero-calculator-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="fs-5 text-white mb-1 fw-bold"><i class="bi bi-calculator me-2"></i>Trip Fare Estimator</h3>
                            <p class="text-white-50 small mb-0">Estimate route distance, fuel consumption & freight rate</p>
                        </div>
                        <span class="badge bg-secondary bg-opacity-50 text-white px-2 py-1 rounded small">
                            Diesel: Rs. {{ number_format($setting->diesel_price ?? 275, 0) }}/L
                        </span>
                    </div>

                    <form id="heroFareForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label text-white-50 small fw-semibold">Pickup City (From)</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" id="heroFromCity" name="from_city" required>
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}" {{ $c == 'Karachi' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label text-white-50 small fw-semibold">Delivery City (To)</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" id="heroToCity" name="to_city" required>
                                    @foreach($cities as $c)
                                        <option value="{{ $c }}" {{ $c == 'Lahore' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-8">
                                <label class="form-label text-white-50 small fw-semibold">Truck Type</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2" id="heroVehicleId" name="vehicle_id" required>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ $v->title }} ({{ $v->min_weight }}-{{ $v->max_weight }} Ton)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label text-white-50 small fw-semibold">Weight (Tons)</label>
                                <input type="number" class="form-control bg-dark text-white border-secondary border-opacity-50 py-2" id="heroWeight" name="weight" value="5" min="1" max="100">
                            </div>

                            <div class="col-12">
                                <button type="button" id="btnCalculateHero" class="btn btn-primary w-100 justify-content-center py-3 fw-semibold">
                                    <i class="bi bi-arrow-right-circle me-1"></i> Calculate Fare Estimate
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Results Box (AJAX Updated) -->
                    <div id="heroCalcResult" class="mt-3 p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25" style="display: none;">
                        <div class="row text-center g-2">
                            <div class="col-4 border-end border-secondary border-opacity-25">
                                <span class="d-block text-white-50 small">Distance</span>
                                <strong class="text-white fs-6" id="resDistance">0 KM</strong>
                            </div>
                            <div class="col-4 border-end border-secondary border-opacity-25">
                                <span class="d-block text-white-50 small">Est. Time</span>
                                <strong class="text-white fs-6" id="resTime">0 Hrs</strong>
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

<!-- 2. ACTUAL APP FEATURES -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 1px;">Core Mobile Features</span>
            <h2 class="fs-2 fw-bold text-dark mt-1">Everything You Need in One App</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Designed specifically for Pakistan's road transport ecosystem, connecting cargo shippers with truck drivers and fleet owners.
            </p>
        </div>

        <div class="row g-4">
            <!-- Feature 1: Post Load -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="feature-title">Post Loads & Get Bids</h3>
                    <p class="feature-desc">
                        Post your cargo requirements with origin, destination, material type, and target rate. Verified drivers submit competitive offers directly.
                    </p>
                </div>
            </div>

            <!-- Feature 2: Find Lorries -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3 class="feature-title">Find Available Lorries</h3>
                    <p class="feature-desc">
                        Browse active trucks and fleet owners by city or route. View vehicle capacity and connect with transporters ready for dispatch.
                    </p>
                </div>
            </div>

            <!-- Feature 3: Digital Bilty -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <i class="bi bi-qr-code"></i>
                    </div>
                    <h3 class="feature-title">Digital E-Bilty with QR</h3>
                    <p class="feature-desc">
                        Generate official consignment notes electronically. Includes consignor, consignee, cargo details, and QR verification for highway checkpoints.
                    </p>
                </div>
            </div>

            <!-- Feature 4: Fare Calculator -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <h3 class="feature-title">Freight Fare Calculator</h3>
                    <p class="feature-desc">
                        Check accurate distance and estimated freight costs between any two Pakistani cities based on truck type, weight, and current diesel rates.
                    </p>
                </div>
            </div>

            <!-- Feature 5: KYC Verification -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="feature-title">Verified Drivers & Vehicles</h3>
                    <p class="feature-desc">
                        Transporters and drivers submit CNIC, driving license, and vehicle registration documents for admin review before booking loads.
                    </p>
                </div>
            </div>

            <!-- Feature 6: Transporter Community -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                    <h3 class="feature-title">Transporter Community</h3>
                    <p class="feature-desc">
                        Stay informed with regional road advisories, weather updates, toll tax information, and group discussions directly inside the app.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. HOW IT WORKS -->
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 1px;">Simple Process</span>
            <h2 class="fs-2 fw-bold text-dark mt-1">How the Platform Works</h2>
            <p class="text-muted mx-auto" style="max-width: 550px;">
                Straightforward workflows whether you are booking a single truck or operating an entire fleet.
            </p>
        </div>

        <ul class="nav nav-pills workflow-tabs justify-content-center gap-2 mb-5" id="workflowTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="shipper-tab" data-bs-toggle="pill" data-bs-target="#shipper-flow" type="button" role="tab">
                    For Cargo Shippers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="transporter-tab" data-bs-toggle="pill" data-bs-target="#transporter-flow" type="button" role="tab">
                    For Truck Owners & Drivers
                </button>
            </li>
        </ul>

        <div class="tab-content" id="workflowTabContent">
            <!-- Shipper Workflow -->
            <div class="tab-pane fade show active" id="shipper-flow" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="step-index">1</div>
                            <h4 class="fs-6 fw-bold text-dark mb-2">Post Your Cargo Load</h4>
                            <p class="text-muted small mb-0">Enter pickup, delivery destination, vehicle requirements, cargo weight, and your offer rate in the app.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="step-index">2</div>
                            <h4 class="fs-6 fw-bold text-dark mb-2">Compare Direct Bids</h4>
                            <p class="text-muted small mb-0">Verified drivers and fleet owners receive alerts and submit price bids. Compare offers and choose the best rate.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="step-index">3</div>
                            <h4 class="fs-6 fw-bold text-dark mb-2">Confirm & Issue E-Bilty</h4>
                            <p class="text-muted small mb-0">Accept the bid, generate an electronic bilty with QR code, and coordinate dispatch directly with the driver.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transporter Workflow -->
            <div class="tab-pane fade" id="transporter-flow" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="step-index">1</div>
                            <h4 class="fs-6 fw-bold text-dark mb-2">Register & Verify Documents</h4>
                            <p class="text-muted small mb-0">Sign up in the app, add your vehicle details, and upload CNIC and license for quick KYC approval.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="step-index">2</div>
                            <h4 class="fs-6 fw-bold text-dark mb-2">Browse Loads & Submit Bids</h4>
                            <p class="text-muted small mb-0">Search active loads in your city or along your return route. Submit your desired freight rate.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="step-index">3</div>
                            <h4 class="fs-6 fw-bold text-dark mb-2">Complete Trip & Get Paid</h4>
                            <p class="text-muted small mb-0">Load cargo, complete the trip under the digital bilty, and receive payment upon safe delivery.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. FLEET DIRECTORY -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 1px;">Supported Fleet</span>
            <h2 class="fs-2 fw-bold text-dark mt-1">Vehicles Supported on Movers</h2>
            <p class="text-muted mx-auto" style="max-width: 550px;">
                From light pickup vans to heavy multi-axle trailers, our network accommodates all cargo categories.
            </p>
        </div>

        <div class="row g-4">
            @foreach($vehicles->take(8) as $veh)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="fleet-card">
                        <div class="fleet-img-wrap">
                            @if(!empty($veh->img) && file_exists(public_path($veh->img)))
                                <img src="{{ asset($veh->img) }}" alt="{{ $veh->title }}" class="fleet-img">
                            @else
                                <div class="text-secondary fs-1"><i class="bi bi-truck"></i></div>
                            @endif
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="fs-6 fw-bold mb-0 text-dark">{{ $veh->title }}</h4>
                                <span class="badge bg-light text-dark border">{{ $veh->min_weight }}-{{ $veh->max_weight }} Tons</span>
                            </div>
                            <div class="border-top pt-2 mt-2 text-muted small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Base Fare:</span>
                                    <strong class="text-dark">Rs. {{ number_format($veh->base_fare ?? 1500) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Rate / KM:</span>
                                    <strong class="text-dark">Rs. {{ number_format($veh->per_km_rate ?? 75) }}</strong>
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

        <div class="text-center mt-4">
            <a href="{{ route('landing.calculator') }}" class="btn btn-outline-dark fw-semibold px-4 py-2 rounded-3">
                <i class="bi bi-calculator me-1"></i> Calculate Rate for Any Vehicle
            </a>
        </div>
    </div>
</section>

<!-- 5. FAQ SECTION -->
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 1px;">Common Queries</span>
            <h2 class="fs-2 fw-bold text-dark mt-1">Frequently Asked Questions</h2>
            <p class="text-muted mx-auto" style="max-width: 550px;">
                Learn how load booking, bidding, and verification work on the Movers platform.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion custom-accordion" id="landingFaqAccordion">
                    @forelse($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#landingFaqAccordion">
                                <div class="accordion-body">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    How does direct driver bidding work?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#landingFaqAccordion">
                                <div class="accordion-body">
                                    When a shipper posts a load, available truck drivers receive a notification and can submit their price offer. The shipper reviews bids and accepts the most suitable driver.
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted small">Have questions? Reach out via our <a href="{{ route('landing.contact') }}" class="text-dark fw-bold">Contact Page</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. APP DOWNLOAD BANNER -->
<section class="section-padding pt-0">
    <div class="container">
        <div class="app-banner">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge bg-secondary bg-opacity-50 text-white px-3 py-1 rounded-pill mb-3 small">
                        Mobile Application
                    </span>
                    <h2 class="text-white fs-2 fw-bold mb-3">Download Movers on Your Mobile Device</h2>
                    <p class="text-white-50 mb-4" style="max-width: 600px;">
                        Manage freight bookings, communicate directly with drivers, view digital bilty receipts, and calculate trip estimates on the go.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('landing.download') }}" class="btn btn-light text-dark fw-bold py-3 px-4 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-google-play fs-5"></i> Google Play Store
                        </a>
                        <a href="{{ route('landing.download') }}" class="btn btn-outline-light fw-bold py-3 px-4 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-apple fs-5"></i> Apple App Store
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-10 d-inline-block text-center">
                        <i class="bi bi-phone text-white fs-1 d-block mb-2"></i>
                        <span class="text-white fw-semibold small">Available for Android & iOS</span>
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
                    btnCalc.innerHTML = '<i class="bi bi-arrow-right-circle me-1"></i> Calculate Fare Estimate';
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
                    btnCalc.innerHTML = '<i class="bi bi-arrow-right-circle me-1"></i> Calculate Fare Estimate';
                    btnCalc.disabled = false;
                    console.error(err);
                });
            });
        }
    });
</script>
@endsection
