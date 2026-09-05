@extends('layouts.landing')

@section('title', 'About Us - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Learn about Movers, Pakistan\'s premier tech-enabled freight network modernizing goods transport with transparency, safety, and digital efficiency.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-info-circle-fill"></i> Corporate Overview</span>
                <h1 class="text-white fs-1 mb-2">Modernizing Freight Logistics Across Pakistan</h1>
                <p class="text-white-50 fs-6 mb-0">Connecting Shippers, Fleet Owners & Industrial Corridors Through Smart Technology.</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">About Us</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-buildings text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- About Story Section -->
<section class="section-padding bg-body">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Our Vision & Mission</span>
                <h2 class="section-title mb-4">Building the Digital Backbone of Pakistan's Logistics</h2>
                <p class="text-muted mb-4">
                    For decades, Pakistan's goods transport sector has operated through fragmented roadside Addas, multi-layered commission agents, non-transparent paper bilties, and unpredictable transit times. 
                </p>
                <p class="text-muted mb-4">
                    <strong>Movers</strong> was founded with a single mission: to empower truck drivers and enterprise cargo shippers through transparent, peer-to-peer digital logistics technology. By eliminating unnecessary broker markups, we ensure transporters earn more while shippers pay fair, competitive rates.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 bg-white border rounded-3 shadow-sm">
                            <h5 class="fs-6 fw-bold text-dark mb-1"><i class="bi bi-bullseye text-primary me-2"></i>Our Mission</h5>
                            <p class="small text-muted mb-0">Democratize truck booking with zero brokerage, verified safety, and real-time visibility.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-white border rounded-3 shadow-sm">
                            <h5 class="fs-6 fw-bold text-dark mb-1"><i class="bi bi-eye text-success me-2"></i>Our Vision</h5>
                            <p class="small text-muted mb-0">To become South Asia's most reliable and interconnected multi-modal freight network.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-4 p-md-5 bg-dark text-white rounded-4 shadow-lg border border-secondary border-opacity-25">
                    <div class="badge bg-primary bg-opacity-25 text-info px-3 py-1 rounded-pill mb-3">
                        <i class="bi bi-award-fill me-1"></i> Core Operational Values
                    </div>
                    <h3 class="brand-font text-white mb-4">The Pillars of Movers</h3>
                    
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex gap-3">
                            <div class="bg-primary bg-opacity-25 text-info rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                                <i class="bi bi-shield-check fs-5"></i>
                            </div>
                            <div>
                                <strong class="text-white d-block">Uncompromising Safety & KYC</strong>
                                <span class="text-white-50 small">Every lorry and driver undergoes biometric and official document verification before account activation.</span>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="bg-success bg-opacity-25 text-success rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                                <i class="bi bi-cash-stack fs-5"></i>
                            </div>
                            <div>
                                <strong class="text-white d-block">Fair inDrive Bidding</strong>
                                <span class="text-white-50 small">Open market dynamics where drivers set their own rates and shippers choose their ideal match.</span>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="bg-warning bg-opacity-25 text-warning rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                                <i class="bi bi-clock-history fs-5"></i>
                            </div>
                            <div>
                                <strong class="text-white d-block">24/7 Real-Time Telematics</strong>
                                <span class="text-white-50 small">End-to-end trip tracking, digital toll logs, and live electronic bilty records.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- National Highway Corridors Covered -->
        <div class="p-4 p-md-5 bg-white border rounded-4 shadow-sm mb-5">
            <div class="text-center mb-4">
                <span class="section-subtitle">Nationwide Reach</span>
                <h3 class="fs-2 text-dark">Connecting Every Trade Hub Across Pakistan</h3>
                <p class="text-muted small">Daily commercial dispatches across all major motorways (M-2, M-3, M-5, M-9, M-14) and National Highway N-5.</p>
            </div>

            <div class="row g-4 text-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="p-3 bg-light rounded-3">
                        <strong class="d-block fs-5 text-dark mb-1">Karachi - Ports Hub</strong>
                        <span class="text-muted small">Port Qasim, KPT, Mauripur Adda, SITE, Korangi</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="p-3 bg-light rounded-3">
                        <strong class="d-block fs-5 text-dark mb-1">Lahore - Central Hub</strong>
                        <span class="text-muted small">Badami Bagh Adda, Multan Road, Sundar, Raiwind</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="p-3 bg-light rounded-3">
                        <strong class="d-block fs-5 text-dark mb-1">Faisalabad - Industrial</strong>
                        <span class="text-muted small">Sargodha Road, Textile Corridors, M-3 City</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="p-3 bg-light rounded-3">
                        <strong class="d-block fs-5 text-dark mb-1">Islamabad / Rawalpindi</strong>
                        <span class="text-muted small">Pirwadhai Adda, I-9 Industrial, CPEC Corridor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
