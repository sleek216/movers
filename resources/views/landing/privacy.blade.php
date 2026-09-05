@extends('layouts.landing')

@section('title', 'Privacy Policy - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Privacy Policy and Data Protection Standards for Shippers, Drivers, and Fleet Transporters using the Movers Platform.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-shield-lock-fill"></i> Data Privacy & Security</span>
                <h1 class="text-white fs-1 mb-2">Privacy & Data Protection Policy</h1>
                <p class="text-white-50 fs-6 mb-0">Last Updated: {{ date('F d, Y') }} | Dedicated to Protecting Your Personal & Freight Data</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">Privacy Policy</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-shield-shaded text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Content Layout -->
<section class="section-padding bg-body">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar Navigation -->
            <div class="col-lg-4">
                <div class="glass-card p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-bookmark-check text-primary me-2"></i>Privacy Highlights</h5>
                    <ul class="nav flex-column gap-2 small">
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-1">1. Information We Collect</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-2">2. Real-Time Location & GPS Tracking</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-3">3. KYC Document & CNIC Security</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-4">4. How We Use Your Information</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-5">5. Data Sharing & Third Parties</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-6">6. Data Retention & High Encryption</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-7">7. Your Data Rights & Deletion</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#privacy-8">8. Data Protection Officer Contact</a></li>
                    </ul>

                    <div class="mt-4 pt-3 border-top">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <i class="bi bi-shield-check text-success fs-3 d-block mb-1"></i>
                            <strong class="d-block small text-dark">256-bit SSL Encrypted</strong>
                            <span class="text-muted" style="font-size: 0.75rem;">Your KYC documents and banking credentials are never exposed.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Privacy Policy Body -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">

                    <!-- Section 1 -->
                    <div id="privacy-1" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">1. Information We Collect</h3>
                        <p class="text-muted">
                            When you register on the Movers application or website, we collect necessary personal, freight, and vehicle details to facilitate logistics operations:
                        </p>
                        <ul class="text-muted">
                            <li><strong>Account Profile:</strong> Full name, verified mobile phone number, email address, company or business name.</li>
                            <li><strong>KYC & Identity Verification:</strong> Scanned copy of National ID (CNIC), Driving License number, and a live facial verification photo (selfie).</li>
                            <li><strong>Vehicle & Fleet Information:</strong> Vehicle registration number, vehicle category, fitness certificate, and payload capacity.</li>
                            <li><strong>Consignment & Shipment Data:</strong> Origin and destination locations, material descriptions, packaging types, and recipient phone numbers.</li>
                            <li><strong>Payment & Wallet Details:</strong> Bank account title, IBAN, EasyPaisa / JazzCash mobile wallet numbers, and transaction logs.</li>
                        </ul>
                    </div>

                    <!-- Section 2 -->
                    <div id="privacy-2" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">2. Real-Time Location & GPS Tracking</h3>
                        <p class="text-muted">
                            To ensure transparent logistics delivery, safety, and electronic milestone updates, the Movers Driver App collects precise GPS location data in both foreground and background modes during an active shipment.
                        </p>
                        <div class="p-3 bg-light rounded-3 border-start border-primary border-4 mb-3">
                            <h6 class="fw-bold text-primary mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Purpose of Location Tracking:</h6>
                            <p class="small text-muted mb-0">
                                Location coordinates are used strictly to calculate accurate trip distances, provide live shipment tracking to the verified cargo shipper, and calculate precise highway toll estimates. Location collection ceases immediately once the load delivery is concluded.
                            </p>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div id="privacy-3" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">3. KYC Document & CNIC Security</h3>
                        <p class="text-muted">
                            Movers treats driver identity and shipper business credentials with the highest level of confidentiality.
                        </p>
                        <ul class="text-muted">
                            <li>All CNIC images and driving licenses are stored on private, encrypted cloud storage accessible only by certified verification administrators.</li>
                            <li>Driver personal phone numbers are masked when necessary to prevent off-platform spamming or unauthorized solicitation.</li>
                        </ul>
                    </div>

                    <!-- Section 4 -->
                    <div id="privacy-4" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">4. How We Use Your Information</h3>
                        <p class="text-muted">
                            We utilize the collected information for the following specific purposes:
                        </p>
                        <ul class="text-muted">
                            <li>To match shippers with nearest verified truck drivers using algorithmic dispatch.</li>
                            <li>To generate legally compliant Digital Bilties (E-LR) with scannable QR verification.</li>
                            <li>To process freight payments, wallet recharges, driver payouts, and escrow releases.</li>
                            <li>To prevent fraud, verify driver authenticity, and resolve freight disputes.</li>
                            <li>To provide customer support and emergency roadside assistance.</li>
                        </ul>
                    </div>

                    <!-- Section 5 -->
                    <div id="privacy-5" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">5. Data Sharing & Third Parties</h3>
                        <p class="text-muted">
                            We do not sell, trade, or rent user personal data to third-party advertisers. Information is only shared in the following strictly controlled scenarios:
                        </p>
                        <ul class="text-muted">
                            <li><strong>Between Shipper and Driver:</strong> Contact numbers and vehicle details are shared between counterparties of an active shipment to facilitate loading and delivery coordination.</li>
                            <li><strong>Payment Gateways & Banks:</strong> Necessary transaction identifiers are transmitted securely to authorized payment processors.</li>
                            <li><strong>Law Enforcement & Highway Authorities:</strong> When required by lawful court order, National Highway Police, or NADRA verifications.</li>
                        </ul>
                    </div>

                    <!-- Section 6 -->
                    <div id="privacy-6" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">6. Data Retention & High-Grade Encryption</h3>
                        <p class="text-muted">
                            All API communications and database records are encrypted using modern Transport Layer Security (TLS 1.3 / SSL) protocols. Consignment records, bilties, and transaction histories are archived in accordance with statutory accounting and tax retention regulations in Pakistan.
                        </p>
                    </div>

                    <!-- Section 7 -->
                    <div id="privacy-7" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">7. Your Data Rights & Deletion</h3>
                        <p class="text-muted">
                            You have the right to inspect, update, or request the deletion of your account and personal profile at any time. You can submit an account deletion or data erasure request directly from the mobile app settings or by writing to our Data Protection Officer.
                        </p>
                    </div>

                    <!-- Section 8 -->
                    <div id="privacy-8">
                        <h3 class="fw-bold text-dark fs-4 mb-3">8. Contact Our Data Protection Officer</h3>
                        <p class="text-muted">
                            If you have questions, feedback, or privacy-related inquiries regarding our practices, please contact our dedicated Data Protection team:
                        </p>
                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-1 text-dark fw-bold">Movers Data Privacy & Governance Team</p>
                            <p class="small text-muted mb-1"><i class="bi bi-envelope-fill me-2"></i> privacy@movers.com</p>
                            <p class="small text-muted mb-0"><i class="bi bi-geo-alt-fill me-2"></i> Head Office: Logistics City, Mauripur Road, Karachi, Pakistan</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
