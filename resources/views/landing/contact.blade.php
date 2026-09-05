@extends('layouts.landing')

@section('title', 'Contact Us & 24/7 Helpdesk - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Get in touch with Movers support, corporate freight desks, and regional transport adda coordinators across Pakistan.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-headset"></i> 24/7 Logistics Assistance</span>
                <h1 class="text-white fs-1 mb-2">Get in Touch with Our Team</h1>
                <p class="text-white-50 fs-6 mb-0">Have an inquiry about corporate freight, driver KYC, or load status? We are always here to help.</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">Contact Us</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-telephone-inbound text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info & Form Section -->
<section class="section-padding bg-body">
    <div class="container">
        
        <!-- Contact Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="glass-card p-4 text-center h-100">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-telephone-fill fs-4"></i>
                    </div>
                    <h5 class="fs-6 fw-bold mb-1">24/7 Call Center</h5>
                    <p class="text-muted small mb-2">For live trip emergencies & dispatch</p>
                    <a href="tel:+923000000000" class="text-primary fw-bold text-decoration-none fs-6">+92 300 0000000</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card p-4 text-center h-100">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-whatsapp fs-4"></i>
                    </div>
                    <h5 class="fs-6 fw-bold mb-1">WhatsApp Helpline</h5>
                    <p class="text-muted small mb-2">Instant messaging & driver support</p>
                    <a href="https://wa.me/923000000000" target="_blank" class="text-success fw-bold text-decoration-none fs-6">Chat on WhatsApp</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card p-4 text-center h-100">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                        <i class="bi bi-envelope-fill fs-4"></i>
                    </div>
                    <h5 class="fs-6 fw-bold mb-1">Email Inquiries</h5>
                    <p class="text-muted small mb-2">For enterprise billing & partnership</p>
                    <a href="mailto:support@movers.com" class="text-info fw-bold text-decoration-none fs-6">support@movers.com</a>
                </div>
            </div>
        </div>

        <!-- Form & Offices -->
        <div class="row g-5">
            <!-- Form -->
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                    <h3 class="fs-4 fw-bold text-dark mb-1">Send Us a Direct Message</h3>
                    <p class="text-muted small mb-4">Fill in your requirements and our logistics team will respond promptly.</p>

                    @if($errors->any())
                        <div class="alert alert-danger p-3 rounded-3 mb-4">
                            <ul class="mb-0 small ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('landing.contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Ahmed Ali" value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Phone Number (WhatsApp) <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="0300 1234567" value="{{ old('phone') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@company.com" value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Subject <span class="text-danger">*</span></label>
                                <select name="subject" class="form-select" required>
                                    <option value="Load Booking Inquiry">Load Booking Inquiry</option>
                                    <option value="Transporter & Driver Registration">Transporter & Driver Registration</option>
                                    <option value="Corporate Enterprise Freight">Corporate Enterprise Freight</option>
                                    <option value="Digital Bilty & Adda Integration">Digital Bilty & Adda Integration</option>
                                    <option value="Payment & Wallet Support">Payment & Wallet Support</option>
                                    <option value="Other Inquiries">Other Inquiries</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark">Your Message / Cargo Details <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Please describe your cargo type, route, or any questions..." required>{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-brand-primary w-100 py-3 justify-content-center fs-6">
                                    <i class="bi bi-send-fill"></i> Submit Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Regional Offices -->
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-4">
                    <!-- Office 1 -->
                    <div class="glass-card p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary text-white">Headquarters</span>
                            <h5 class="fs-6 fw-bold mb-0 text-dark">Karachi Regional Hub</h5>
                        </div>
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt text-primary me-1"></i> Plot # 42, Goods Transport Corridor, Mauripur Road, Hawksbay Junction, Karachi.</p>
                        <p class="text-muted small mb-0"><i class="bi bi-telephone text-primary me-1"></i> +92 21 30000000</p>
                    </div>

                    <!-- Office 2 -->
                    <div class="glass-card p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success text-white">Central Hub</span>
                            <h5 class="fs-6 fw-bold mb-0 text-dark">Lahore Regional Office</h5>
                        </div>
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt text-success me-1"></i> Suite 12, Badami Bagh Commercial Complex, Circular Road, Lahore.</p>
                        <p class="text-muted small mb-0"><i class="bi bi-telephone text-success me-1"></i> +92 42 30000000</p>
                    </div>

                    <!-- Office 3 -->
                    <div class="glass-card p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-info text-dark">North Hub</span>
                            <h5 class="fs-6 fw-bold mb-0 text-dark">Islamabad / Rawalpindi</h5>
                        </div>
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt text-info me-1"></i> Sector I-9 Industrial Area, Near Freight Terminal, Islamabad.</p>
                        <p class="text-muted small mb-0"><i class="bi bi-telephone text-info me-1"></i> +92 51 30000000</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
