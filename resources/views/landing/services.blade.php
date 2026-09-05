@extends('layouts.landing')

@section('title', 'Logistics & Freight Services - ' . ($setting->webname ?? 'Movers'))
@section('meta_description', 'Explore Movers comprehensive freight transportation services including Full Truckload, Cold Storage Reefers, Container Haulage, and Digital Bilty solutions.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-gear-wide-connected"></i> Comprehensive Logistics Portfolio</span>
                <h1 class="text-white fs-1 mb-2">Tailored Transportation & Freight Solutions</h1>
                <p class="text-white-50 fs-6 mb-0">From single pallets to mega industrial machinery, we deliver safely across Pakistan.</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">Services</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-truck-flatbed text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="section-padding bg-body">
    <div class="container">
        <div class="row g-4">
            
            <!-- Service 1: FTL -->
            <div class="col-lg-4 col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3 class="fs-5 fw-bold text-dark mb-2">Full Truckload (FTL)</h3>
                    <p class="text-muted small flex-grow-1">
                        Dedicated trucks exclusively reserved for your cargo from origin directly to destination. Ideal for FMCG manufacturers, textile mills, agriculture, and high-volume dispatches.
                    </p>
                    <ul class="text-muted small mb-4 ps-3">
                        <li>Direct point-to-point transit</li>
                        <li>Dedicated tamper-evident sealing</li>
                        <li>Instant driver bidding & assignment</li>
                    </ul>
                    <a href="{{ route('landing.calculator') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold w-100">
                        Calculate FTL Fare <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Service 2: Container Drayage -->
            <div class="col-lg-4 col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 fs-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h3 class="fs-5 fw-bold text-dark mb-2">Container & Port Drayage</h3>
                    <p class="text-muted small flex-grow-1">
                        Heavy 20ft and 40ft High Cube container transport from Karachi ports (KPT, QICT, SAPT) to dry ports and industrial zones across Punjab and KPK.
                    </p>
                    <ul class="text-muted small mb-4 ps-3">
                        <li>Port gate clearance assistance</li>
                        <li>Bonded & non-bonded carrier options</li>
                        <li>Heavy 22-wheeler articulated trailers</li>
                    </ul>
                    <a href="{{ route('landing.calculator') }}" class="btn btn-outline-success btn-sm rounded-pill fw-bold w-100">
                        Check Container Rates <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Service 3: Cold Chain Logistics -->
            <div class="col-lg-4 col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 fs-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-snow2"></i>
                    </div>
                    <h3 class="fs-5 fw-bold text-dark mb-2">Cold Storage Reefer Vans</h3>
                    <p class="text-muted small flex-grow-1">
                        Temperature-controlled insulated reefer containers for pharmaceuticals, frozen meat, dairy, ice cream, and seasonal fruits from farm to market.
                    </p>
                    <ul class="text-muted small mb-4 ps-3">
                        <li>Temperature ranges from -25°C to +15°C</li>
                        <li>Active IoT temperature monitoring</li>
                        <li>Backup refrigeration engines</li>
                    </ul>
                    <a href="{{ route('landing.calculator') }}" class="btn btn-outline-info btn-sm rounded-pill fw-bold w-100">
                        Book Reefer Van <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Service 4: Heavy Haulage -->
            <div class="col-lg-4 col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 fs-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-tools"></i>
                    </div>
                    <h3 class="fs-5 fw-bold text-dark mb-2">Heavy Haulage & Lowbeds</h3>
                    <p class="text-muted small flex-grow-1">
                        Specialized transport for oversized construction machinery, transformers, excavators, steel girders, and power plant project cargo.
                    </p>
                    <ul class="text-muted small mb-4 ps-3">
                        <li>Hydraulic multi-axle trailers & lowbeds</li>
                        <li>Route survey & police escort planning</li>
                        <li>Over-dimensional cargo (ODC) permits</li>
                    </ul>
                    <a href="{{ route('landing.contact') }}" class="btn btn-outline-warning text-dark btn-sm rounded-pill fw-bold w-100">
                        Inquire Project Cargo <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Service 5: Digital Bilty (E-LR) -->
            <div class="col-lg-4 col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="bg-indigo bg-opacity-10 text-indigo p-3 rounded-3 fs-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background-color: #EEF2FF; color: #4F46E5;">
                        <i class="bi bi-file-earmark-code-fill"></i>
                    </div>
                    <h3 class="fs-5 fw-bold text-dark mb-2">Digital Bilty & Adda Register</h3>
                    <p class="text-muted small flex-grow-1">
                        Paperless consignment management for logistics companies, freight forwarders, and goods Addas. Generate scannable QR Bilties in seconds.
                    </p>
                    <ul class="text-muted small mb-4 ps-3">
                        <li>Checkpoint verification via QR code</li>
                        <li>Instant PDF invoice & dispatch notes</li>
                        <li>Permanent cloud archive & export</li>
                    </ul>
                    <a href="{{ route('landing.download') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold w-100">
                        Generate Digital Bilty <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Service 6: Enterprise Logistics -->
            <div class="col-lg-4 col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3 fs-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-building-check"></i>
                    </div>
                    <h3 class="fs-5 fw-bold text-dark mb-2">Enterprise Dedicated Fleets</h3>
                    <p class="text-muted small flex-grow-1">
                        Custom logistics contracts for major corporate enterprises, e-commerce distribution centers, and nationwide retail distributor networks.
                    </p>
                    <ul class="text-muted small mb-4 ps-3">
                        <li>Dedicated account manager & SLA</li>
                        <li>Monthly consolidated billing</li>
                        <li>Priority driver allocation</li>
                    </ul>
                    <a href="{{ route('landing.contact') }}" class="btn btn-outline-danger btn-sm rounded-pill fw-bold w-100">
                        Contact Enterprise Desk <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- CTA Box -->
        <div class="mt-5 p-4 p-md-5 bg-dark text-white rounded-4 text-center">
            <h3 class="fs-2 text-white mb-2">Need a Custom Freight Quote?</h3>
            <p class="text-white-50 mb-4 max-w-600 mx-auto">Our logistics consultants are available 24/7 to provide instant customized routing and vehicle recommendations for your cargo.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('landing.calculator') }}" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-3">
                    <i class="bi bi-calculator"></i> Live Fare Calculator
                </a>
                <a href="{{ route('landing.contact') }}" class="btn btn-outline-light fw-bold px-4 py-2 rounded-3">
                    <i class="bi bi-telephone-fill"></i> Talk to Expert
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
