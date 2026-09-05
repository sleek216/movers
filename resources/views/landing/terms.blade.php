@extends('layouts.landing')

@section('title', 'Terms & Conditions - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Official Terms and Conditions for Shippers, Cargo Owners, Transporters, and Drivers using the Movers Freight & Logistics Platform.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-shield-check"></i> Legal Framework & Compliance</span>
                <h1 class="text-white fs-1 mb-2">Terms and Conditions of Service</h1>
                <p class="text-white-50 fs-6 mb-0">Effective Date: {{ date('F d, Y') }} | Version 2.4 | Applicable across Pakistan Jurisdiction</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">Terms & Conditions</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-file-earmark-text text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Terms Content Layout -->
<section class="section-padding bg-body">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar Navigation for Legal Sections -->
            <div class="col-lg-4">
                <div class="glass-card p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-list-nested text-primary me-2"></i>Document Sections</h5>
                    <ul class="nav flex-column gap-2 small">
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-1">1. Acceptance & Nature of Service</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-2">2. Shipper Obligations & Prohibited Cargo</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-3">3. Transporter & Driver Verification (KYC)</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-4">4. inDrive-Style Bidding & Contract Formation</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-5">5. Digital Bilty (E-LR) & Legal Validity</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-6">6. Freight Payments, Escrow & Wallet</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-7">7. Cancellations, Detention & Demurrage</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-8">8. Cargo Loss, Damage & Insurance Disclaimer</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-9">9. Real-Time GPS Tracking & Telematics</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-10">10. Movers Adda & Community Code of Conduct</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-11">11. Dispute Resolution & Governing Law</a></li>
                        <li class="nav-item"><a class="nav-link px-2 py-1 text-muted" href="#section-12">12. Amendments & Contact Information</a></li>
                    </ul>

                    <div class="mt-4 pt-3 border-top text-center">
                        <a href="{{ route('landing.contact') }}" class="btn btn-brand-primary w-100 btn-sm">
                            <i class="bi bi-question-circle"></i> Need Legal Clarification?
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Legal Body -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                    
                    <div class="alert alert-info border-0 rounded-3 mb-5 d-flex gap-3 align-items-center">
                        <i class="bi bi-info-circle-fill fs-3 text-primary"></i>
                        <div class="small">
                            <strong>Important Notice:</strong> By downloading, registering, accessing, or using the Movers mobile application or web portal, you agree to be legally bound by these Terms and Conditions. Please review them carefully.
                        </div>
                    </div>

                    <!-- Section 1 -->
                    <div id="section-1" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">1. Acceptance of Terms & Nature of Service</h3>
                        <p class="text-muted">
                            Movers ("Platform", "We", "Us", or "Our") operates a technology platform that connects cargo owners, shippers, manufacturers, and logistics brokers ("Shippers") with independent commercial vehicle owners, fleet operators, and commercial drivers ("Transporters" or "Drivers").
                        </p>
                        <p class="text-muted">
                            Movers acts solely as an intermediary technology aggregator. We do not own the commercial transport vehicles listed by independent third parties, nor do we employ the drivers unless explicitly stated. The contract for freight carriage is directly agreed between the Shipper and the Transporter upon acceptance of a price bid.
                        </p>
                    </div>

                    <!-- Section 2 -->
                    <div id="section-2" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">2. Shipper Obligations & Prohibited Goods</h3>
                        <p class="text-muted">
                            As a Shipper utilizing the platform, you represent and warrant that:
                        </p>
                        <ul class="text-muted mb-3">
                            <li>All information provided in the load posting (including exact weight, material dimensions, pickup/drop coordinates, and contact details) is accurate and complete.</li>
                            <li>The cargo is legally owned by you or you possess lawful authorization to transport it under the laws of Pakistan.</li>
                            <li>The cargo is properly packed, wrapped, and secured to withstand normal transit conditions across national highways.</li>
                        </ul>
                        <div class="p-3 bg-light rounded-3 border-start border-danger border-4 mb-3">
                            <h6 class="fw-bold text-danger mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Strictly Prohibited Cargo:</h6>
                            <p class="small text-muted mb-0">
                                The carriage of illegal narcotics, weapons, ammunition, stolen property, unmanifested currency, undeclared hazardous/explosive chemicals, or any goods restricted under the Pakistan Customs Act 1969 is strictly forbidden. Any violation will result in immediate permanent account termination and legal reporting to law enforcement authorities.
                            </p>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div id="section-3" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">3. Transporter & Driver Verification (KYC)</h3>
                        <p class="text-muted">
                            Every Transporter, Fleet Owner, and Driver operating on Movers must complete mandatory Know-Your-Customer (KYC) identity and vehicle verification prior to bidding on loads. Required documentation includes:
                        </p>
                        <ul class="text-muted mb-3">
                            <li>Valid Computerized National Identity Card (CNIC) issued by NADRA.</li>
                            <li>Valid Commercial Driving License (HTV / LTV) matching the vehicle class.</li>
                            <li>Vehicle Registration Book / Token Tax Receipt proving lawful possession.</li>
                            <li>Live Facial Photo Verification (Selfie) for active identity authentication.</li>
                        </ul>
                        <p class="text-muted">
                            Transporters must maintain their vehicles in roadworthy mechanical condition, complying with National Highway and Motorway Police (NHMP) axle load standards.
                        </p>
                    </div>

                    <!-- Section 4 -->
                    <div id="section-4" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">4. inDrive-Style Bidding & Contract Formation</h3>
                        <p class="text-muted">
                            Movers operates on an open, transparent peer-to-peer bidding model:
                        </p>
                        <ul class="text-muted">
                            <li><strong>Load Posting:</strong> The Shipper publishes a load request with an offered base price.</li>
                            <li><strong>Direct Bidding:</strong> Verified Drivers submit price bids. Drivers may accept the shipper's price or counter-offer a custom rate.</li>
                            <li><strong>Binding Agreement:</strong> A binding carriage contract is formed the exact moment the Shipper taps "Accept Bid". Neither party may arbitrarily alter agreed freight rates following acceptance.</li>
                        </ul>
                    </div>

                    <!-- Section 5 -->
                    <div id="section-5" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">5. Digital Bilty (E-LR) & Legal Validity</h3>
                        <p class="text-muted">
                            Upon bid confirmation, the platform automatically generates an Electronic Lorry Receipt / Digital Bilty ("E-Bilty") containing a secure QR verification code, consignment details, freight rates, vehicle registration, and driver credentials.
                        </p>
                        <p class="text-muted">
                            Under the Electronic Transactions Ordinance (ETO 2002) of Pakistan, the Digital Bilty produced by Movers holds full legal admissibility as a formal freight consignment note across all provincial checkpoints, excise toll plazas, and weighing scales.
                        </p>
                    </div>

                    <!-- Section 6 -->
                    <div id="section-6" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">6. Freight Payments, Escrow & In-App Wallet</h3>
                        <p class="text-muted">
                            To ensure total financial security for both parties:
                        </p>
                        <ul class="text-muted">
                            <li>Freight payments may be settled via in-app Wallet, Bank Transfer, EasyPaisa, JazzCash, or verified Cash-on-Delivery (COD) as mutually agreed in the load post.</li>
                            <li>When using digital payment, funds are held securely in the Movers Escrow Wallet and are only disbursed to the Transporter once the consignee confirms delivery and the driver submits Proof of Delivery (POD).</li>
                            <li>Platform service fees or commissions are transparently deducted based on published fee schedules.</li>
                        </ul>
                    </div>

                    <!-- Section 7 -->
                    <div id="section-7" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">7. Cancellations, Detention & Demurrage Charges</h3>
                        <p class="text-muted">
                            <strong>Cancellation by Shipper:</strong> If a Shipper cancels a load after a driver has arrived at the loading site, a standard dry-run cancellation fee (Rs. 1,500 - Rs. 5,000 depending on vehicle category) shall be charged and compensated to the driver.
                        </p>
                        <p class="text-muted">
                            <strong>Loading / Unloading Detention:</strong> Drivers provide a complimentary 4-hour free loading and 4-hour free unloading window. Unreasonable detention exceeding this period shall incur demurrage charges at published standard hourly rates.
                        </p>
                    </div>

                    <!-- Section 8 -->
                    <div id="section-8" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">8. Cargo Loss, Damage & Insurance Disclaimer</h3>
                        <p class="text-muted">
                            Movers facilitates logistics connections but does not directly assume physical custody of freight during transit. Shippers are strongly advised to procure comprehensive transit cargo insurance for high-value merchandise. Transporters are liable for gross negligence, reckless driving, or unauthorized diversion of goods under the Carriers Act 1865.
                        </p>
                    </div>

                    <!-- Section 9 -->
                    <div id="section-9" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">9. Real-Time GPS Tracking & Telematics</h3>
                        <p class="text-muted">
                            Transporters and drivers agree to keep device GPS location enabled during active trip execution. Location data is shared exclusively with the authorized shipper and platform monitoring team to ensure safety and route integrity.
                        </p>
                    </div>

                    <!-- Section 10 -->
                    <div id="section-10" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">10. Movers Adda & Community Code of Conduct</h3>
                        <p class="text-muted">
                            Members of the Movers Adda community channels agree to maintain professional etiquette. Spamming, harassment, sharing misleading highway rumors, or soliciting fraudulent off-platform transactions is strictly forbidden.
                        </p>
                    </div>

                    <!-- Section 11 -->
                    <div id="section-11" class="mb-5">
                        <h3 class="fw-bold text-dark fs-4 mb-3">11. Dispute Resolution & Governing Law</h3>
                        <p class="text-muted">
                            These Terms and any dispute arising out of or in connection with the Platform shall be governed by and construed in accordance with the laws of the Islamic Republic of Pakistan. The courts of Karachi/Lahore shall have exclusive jurisdiction.
                        </p>
                    </div>

                    <!-- Section 12 -->
                    <div id="section-12">
                        <h3 class="fw-bold text-dark fs-4 mb-3">12. Amendments & Contact Information</h3>
                        <p class="text-muted">
                            We reserve the right to modify these Terms at any time. Continued use of the platform constitutes acceptance of updated terms.
                        </p>
                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-1 text-dark fw-bold">Movers Legal & Compliance Department</p>
                            <p class="small text-muted mb-1"><i class="bi bi-envelope-fill me-2"></i> legal@movers.com</p>
                            <p class="small text-muted mb-0"><i class="bi bi-telephone-fill me-2"></i> +92 300 0000000 | Karachi & Lahore, Pakistan</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
