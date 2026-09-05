@extends('layouts.landing')

@section('title', 'Frequently Asked Questions & Help - ' . ($setting->webname ?? 'Movers Logistics'))
@section('meta_description', 'Find answers to common questions regarding load posting, driver bidding, KYC verifications, wallet payouts, and electronic bilty.')

@section('content')

<!-- Page Hero Banner -->
<section class="page-hero-banner">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-brand mb-3"><i class="bi bi-question-circle-fill"></i> Help Center & Knowledgebase</span>
                <h1 class="text-white fs-1 mb-2">Frequently Asked Questions</h1>
                <p class="text-white-50 fs-6 mb-0">Instant answers to everything about load bookings, driver bidding, and digital bilty.</p>
                
                <div class="custom-breadcrumb">
                    <a href="{{ route('landing.home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                    <span class="text-white">FAQs</span>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-patch-question text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
            </div>
        </div>
    </div>
</section>

<!-- FAQs Section -->
<section class="section-padding bg-body">
    <div class="container">
        
        <!-- Search Input -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7">
                <div class="input-group input-group-lg shadow-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="faqSearchInput" class="form-control border-start-0 fs-6" placeholder="Search questions (e.g., bidding, KYC, bilty, payment, cancel)...">
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion custom-accordion" id="fullFaqAccordion">
                    @forelse($faqs as $index => $faq)
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="headingFaq{{ $faq->id }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapseFaq{{ $faq->id }}">
                                    <span class="faq-question-text">{{ $faq->question }}</span>
                                </button>
                            </h2>
                            <div id="collapseFaq{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="headingFaq{{ $faq->id }}" data-bs-parent="#fullFaqAccordion">
                                <div class="accordion-body faq-answer-text">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No FAQs found.</p>
                    @endforelse
                </div>

                <!-- Still need help card -->
                <div class="mt-5 p-4 p-md-5 bg-white border rounded-4 text-center shadow-sm">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-headset fs-2"></i>
                    </div>
                    <h3 class="fs-4 fw-bold text-dark mb-2">Still Have Questions?</h3>
                    <p class="text-muted small mb-4 max-w-500 mx-auto">Can't find the answer you're looking for? Please reach out to our dedicated 24/7 customer care team.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('landing.contact') }}" class="btn btn-brand-primary">
                            <i class="bi bi-chat-left-dots-fill"></i> Contact Support
                        </a>
                        <a href="https://wa.me/923000000000" target="_blank" class="btn btn-outline-success fw-bold d-inline-flex align-items-center gap-2">
                            <i class="bi bi-whatsapp"></i> WhatsApp Helpdesk
                        </a>
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
        const searchInput = document.getElementById('faqSearchInput');
        const faqItems = document.querySelectorAll('.faq-item');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const query = this.value.toLowerCase().trim();

                faqItems.forEach(item => {
                    const qText = item.querySelector('.faq-question-text').textContent.toLowerCase();
                    const aText = item.querySelector('.faq-answer-text').textContent.toLowerCase();

                    if (qText.includes(query) || aText.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
