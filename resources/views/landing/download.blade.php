@extends('layouts.landing')

@section('title', 'Download Movers Mobile App - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Download the official Movers App for Android & iOS. Post freight loads, receive inDrive-style driver bids, and track commercial shipments with live GPS.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-phone-fill"></i> Mobile Experience</span>
                <h1 class="text-white fs-1 mb-2">Download the Movers Logistics App</h1>
                <p class="text-white-50 fs-6 mb-0">Experience real-time freight bidding and digital bilties on Android and iOS.</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">Download App</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-phone text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Download Hub -->
<section class="section-padding bg-body">
    <div class="container">
        
        <!-- Main Download Showcase -->
        <div class="p-4 p-md-5 bg-white border rounded-4 shadow-sm mb-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="section-subtitle">Next-Gen Freight Booking</span>
                    <h2 class="fs-2 fw-bold text-dark mb-3">One App for All Your Cargo & Fleet Operations</h2>
                    <p class="text-muted mb-4">
                        Whether you are an enterprise shipper managing 50 shipments a day or an independent lorry driver seeking profitable return freight, the Movers app is built to streamline your workflow.
                    </p>

                    <!-- Store Buttons -->
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="#" class="btn btn-dark text-start d-flex align-items-center gap-3 p-3 rounded-3 shadow-sm px-4">
                            <i class="bi bi-google-play fs-2 text-warning"></i>
                            <div>
                                <span class="d-block text-uppercase" style="font-size: 0.7rem; color: #94A3B8;">Get it on</span>
                                <strong class="text-white fs-6">Google Play</strong>
                            </div>
                        </a>

                        <a href="#" class="btn btn-dark text-start d-flex align-items-center gap-3 p-3 rounded-3 shadow-sm px-4">
                            <i class="bi bi-apple fs-2 text-white"></i>
                            <div>
                                <span class="d-block text-uppercase" style="font-size: 0.7rem; color: #94A3B8;">Download on</span>
                                <strong class="text-white fs-6">App Store</strong>
                            </div>
                        </a>

                        <a href="#" class="btn btn-outline-primary text-start d-flex align-items-center gap-3 p-3 rounded-3 px-4">
                            <i class="bi bi-android2 fs-2"></i>
                            <div>
                                <span class="d-block text-uppercase" style="font-size: 0.7rem;">Direct Download</span>
                                <strong class="fs-6">Android APK (v1.3)</strong>
                            </div>
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-4 text-muted small">
                        <span><i class="bi bi-check-circle-fill text-success me-1"></i> Version 1.3 (Latest)</span>
                        <span><i class="bi bi-check-circle-fill text-success me-1"></i> 100% Virus & Malware Free</span>
                        <span><i class="bi bi-check-circle-fill text-success me-1"></i> 4.8 ★ Rated (10k+ Downloads)</span>
                    </div>
                </div>

                <!-- QR Scanner Box -->
                <div class="col-lg-5 text-center">
                    <div class="p-4 bg-light rounded-4 border d-inline-block text-center shadow-sm">
                        <div class="p-3 bg-white rounded-3 shadow-sm mb-3">
                            <i class="bi bi-qr-code text-dark" style="font-size: 9rem; line-height: 1;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Scan to Install on Phone</h6>
                        <span class="text-muted small">Point your mobile camera at this QR code</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- App Features Breakdown -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-primary text-white p-2"><i class="bi bi-box-seam fs-5"></i></span>
                        <h4 class="fs-5 fw-bold text-dark mb-0">Shipper App Features</h4>
                    </div>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                        <li><i class="bi bi-check2 text-primary me-2 fw-bold"></i> Instant load publishing in under 60 seconds</li>
                        <li><i class="bi bi-check2 text-primary me-2 fw-bold"></i> Real-time driver bidding with counter-offers</li>
                        <li><i class="bi bi-check2 text-primary me-2 fw-bold"></i> Turn-by-turn live GPS vehicle tracking on map</li>
                        <li><i class="bi bi-check2 text-primary me-2 fw-bold"></i> Digital Bilty PDF generation with QR verification</li>
                        <li><i class="bi bi-check2 text-primary me-2 fw-bold"></i> Escrow wallet with secure bank payment options</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-success text-white p-2"><i class="bi bi-truck fs-5"></i></span>
                        <h4 class="fs-5 fw-bold text-dark mb-0">Driver & Fleet App Features</h4>
                    </div>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                        <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Instant notification for loads matching your vehicle type</li>
                        <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> inDrive-style custom price bidding with zero commission</li>
                        <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Built-in return trip load matching (zero empty miles)</li>
                        <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Movers Adda community channels & toll advisories</li>
                        <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Instant earnings withdrawal to bank or mobile wallet</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
