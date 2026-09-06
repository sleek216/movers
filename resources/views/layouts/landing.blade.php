<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Movers - Pakistan\'s #1 Digital Freight & Logistics Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Movers connects shippers, cargo owners, and factory logistics with 10,000+ verified truck drivers across Pakistan. Zero brokerage, inDrive-style fair bidding, real-time GPS tracking, and digital bilty.')">
    <meta name="keywords" content="logistics pakistan, freight transport, truck booking app, lorry hire, indrive for trucks, online bilty, goods transport karachi lahore islamabad">
    
    <!-- Open Graph / SEO -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Movers - Digital Freight & Logistics')">
    <meta property="og:description" content="Direct truck booking, fair bidding, real-time tracking, and instant delivery across Pakistan.">
    <meta property="og:image" content="{{ asset($setting->weblogo ?? 'images/logo_1787774571.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons & FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #3730A3;
            --primary-light: #EEF2FF;
            --accent-blue: #2563EB;
            --accent-cyan: #06B6D4;
            --accent-emerald: #10B981;
            --accent-amber: #F59E0B;
            --bg-dark: #0B1120;
            --bg-card-dark: #1E293B;
            --bg-body: #F8FAFC;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --text-light: #F8FAFC;
            --border-light: #E2E8F0;
            --border-dark: rgba(255, 255, 255, 0.1);
            --radius-md: 14px;
            --radius-lg: 20px;
            --shadow-soft: 0 10px 30px -5px rgba(15, 23, 42, 0.08);
            --shadow-glow: 0 10px 25px -5px rgba(79, 70, 229, 0.35);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-body);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        /* Top Announcement Bar */
        .top-announcement {
            background: linear-gradient(90deg, #1E1B4B 0%, #312E81 50%, #1E1B4B 100%);
            color: #E0E7FF;
            font-size: 0.85rem;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Glassmorphic Navbar */
        .main-navbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
            z-index: 1050;
        }

        .main-navbar.scrolled {
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            padding: 8px 0 !important;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155 !important;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }

        /* Buttons & Highlights */
        .btn-brand-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent-blue) 100%);
            color: #ffffff;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            box-shadow: var(--shadow-glow);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-brand-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -5px rgba(79, 70, 229, 0.45);
            color: #ffffff;
        }

        .btn-brand-secondary {
            background: #ffffff;
            color: var(--text-dark);
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-brand-secondary:hover {
            background-color: #F1F5F9;
            color: var(--primary);
            border-color: #CBD5E1;
            transform: translateY(-2px);
        }

        .btn-brand-outline-light {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-brand-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-color: #ffffff;
        }

        /* Gradient Texts & Badges */
        .gradient-text {
            background: linear-gradient(135deg, #4F46E5 0%, #06B6D4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-text-light {
            background: linear-gradient(135deg, #FFFFFF 0%, #93C5FD 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .badge-brand {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.8rem;
            padding: 6px 14px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Section Styling */
        .section-padding {
            padding: 90px 0;
        }

        .section-header {
            margin-bottom: 50px;
        }

        .section-subtitle {
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 2.5rem;
            line-height: 1.25;
            color: var(--text-dark);
            margin-bottom: 16px;
        }

        .section-desc {
            font-size: 1.1rem;
            color: var(--text-muted);
            max-width: 650px;
            margin: 0 auto;
        }

        /* Glass and Cards */
        .glass-card {
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12);
            border-color: #CBD5E1;
        }

        .dark-glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-lg);
            color: var(--text-light);
        }

        /* Banner Hero & Page Hero */
        .page-hero-banner {
            background: linear-gradient(135deg, #0B1120 0%, #1E1B4B 50%, #0F172A 100%);
            color: #ffffff;
            padding: 90px 0 70px 0;
            position: relative;
            overflow: hidden;
        }

        .page-hero-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-hero-banner::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Breadcrumbs */
        .custom-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #94A3B8;
            margin-top: 15px;
        }

        .custom-breadcrumb a {
            color: #E2E8F0;
            text-decoration: none;
            transition: color 0.2s;
        }

        .custom-breadcrumb a:hover {
            color: #60A5FA;
        }

        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating-elem {
            animation: float 4s ease-in-out infinite;
        }

        /* Footer */
        .main-footer {
            background-color: var(--bg-dark);
            color: #94A3B8;
            padding: 80px 0 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-title {
            color: #FFFFFF;
            font-size: 1.15rem;
            margin-bottom: 22px;
            position: relative;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #94A3B8;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: #FFFFFF;
            transform: translateX(4px);
        }

        .footer-bottom {
            padding-top: 30px;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.9rem;
        }

        /* Scroll to top */
        #scrollTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
            border: none;
            z-index: 999;
            cursor: pointer;
            transition: all 0.3s;
        }

        #scrollTopBtn:hover {
            transform: translateY(-3px);
            background: var(--primary-dark);
        }

        /* WhatsApp Floating Chat Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: #25D366;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 50px;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            z-index: 998;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 12px 28px rgba(37, 211, 102, 0.5);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-announcement d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4 text-white-50 small">
                    <span><i class="bi bi-truck me-1 text-white"></i> Verified Freight Network Pakistan</span>
                    <span><i class="bi bi-fuel-pump me-1 text-white"></i> Diesel Rate: <strong class="text-white">Rs. {{ number_format($setting->diesel_price ?? 275, 0) }}/L</strong></span>
                    <span><i class="bi bi-telephone me-1 text-white"></i> Helpline: <strong class="text-white">+92 300 0000000</strong></span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('landing.calculator') }}" class="text-white text-decoration-none small"><i class="bi bi-calculator me-1"></i> Fare Calculator</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('landing.home') }}">
                @if(!empty($setting->weblogo) && file_exists(public_path($setting->weblogo)))
                    <img src="{{ asset($setting->weblogo) }}" alt="Movers Logo" height="42" class="d-inline-block align-text-top">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-3 shadow-sm" style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-truck-fast fs-5"></i>
                    </div>
                @endif
                <div class="d-flex flex-column">
                    <span class="brand-font fs-4 fw-bold text-dark lh-1">{{ $setting->webname ?? 'MOVERS' }}</span>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.68rem; letter-spacing: 1px;">Freight & Logistics</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.home') ? 'active' : '' }}" href="{{ route('landing.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.services') ? 'active' : '' }}" href="{{ route('landing.services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.calculator') ? 'active' : '' }}" href="{{ route('landing.calculator') }}">Fare Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.about') ? 'active' : '' }}" href="{{ route('landing.about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.faq') ? 'active' : '' }}" href="{{ route('landing.faq') }}">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.contact') ? 'active' : '' }}" href="{{ route('landing.contact') }}">Contact</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('landing.calculator') }}" class="btn btn-brand-secondary d-none d-xl-inline-flex py-2 px-3 fs-6">
                        <i class="bi bi-calculator"></i> Quick Rate
                    </a>
                    <a href="{{ route('landing.download') }}" class="btn btn-brand-primary py-2 px-4 fs-6">
                        <i class="bi bi-phone-fill"></i> Get App
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success Alerts / Session Flash -->
    @if(session('contact_success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 p-3 rounded-4" role="alert">
                <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                <div>
                    <strong>Success!</strong> {{ session('contact_success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Main Content Yield -->
    <main>
        @yield('content')
    </main>

    <!-- Floating WhatsApp Helpline -->
    <a href="https://wa.me/923000000000?text=Hello%20Movers%20Logistics%20Support" target="_blank" class="whatsapp-float d-none d-sm-flex" title="Chat on WhatsApp">
        <i class="bi bi-whatsapp fs-5"></i>
        <span>24/7 Helpline</span>
    </a>

    <!-- Scroll To Top Button -->
    <button id="scrollTopBtn" title="Back to top">
        <i class="bi bi-chevron-up fs-5"></i>
    </button>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-3" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-truck-fast fs-5"></i>
                        </div>
                        <span class="brand-font fs-4 fw-bold text-white">{{ $setting->webname ?? 'MOVERS' }}</span>
                    </div>
                    <p class="text-muted pe-lg-4 mb-4">
                        Pakistan's premier next-generation digital freight matching, lorry brokerage, and fleet management platform connecting enterprise shippers with verified transport owners.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('landing.home') }}"><i class="bi bi-chevron-right text-primary"></i> Home</a></li>
                        <li><a href="{{ route('landing.about') }}"><i class="bi bi-chevron-right text-primary"></i> About Us</a></li>
                        <li><a href="{{ route('landing.services') }}"><i class="bi bi-chevron-right text-primary"></i> Services</a></li>
                        <li><a href="{{ route('landing.calculator') }}"><i class="bi bi-chevron-right text-primary"></i> Fare Calculator</a></li>
                        <li><a href="{{ route('landing.faq') }}"><i class="bi bi-chevron-right text-primary"></i> FAQs & Help</a></li>
                        <li><a href="{{ route('landing.contact') }}"><i class="bi bi-chevron-right text-primary"></i> Contact Us</a></li>
                    </ul>
                </div>

                <!-- Legal & Policies -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h5 class="footer-title">Trust & Legal</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('landing.terms') }}"><i class="bi bi-shield-check text-primary"></i> Terms & Conditions</a></li>
                        <li><a href="{{ route('landing.privacy') }}"><i class="bi bi-lock-fill text-primary"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('landing.terms') }}#shipper-rules"><i class="bi bi-box-seam text-primary"></i> Cargo & Shipper Rules</a></li>
                        <li><a href="{{ route('landing.terms') }}#bilty-policy"><i class="bi bi-file-earmark-text text-primary"></i> Digital Bilty Policy</a></li>
                        <li><a href="{{ route('landing.privacy') }}#kyc-security"><i class="bi bi-person-check text-primary"></i> KYC & Data Security</a></li>
                    </ul>
                </div>

                <!-- Get the App / Newsletter -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Download Movers App</h5>
                    <p class="small text-muted mb-3">Experience instant load booking & direct driver bidding in the palm of your hand.</p>
                    
                    <div class="d-flex flex-column gap-2 mb-4">
                        <a href="{{ route('landing.download') }}" class="btn btn-dark text-start d-flex align-items-center gap-3 p-2 rounded-3 border border-secondary border-opacity-25">
                            <i class="bi bi-google-play fs-3 text-warning"></i>
                            <div>
                                <span class="d-block text-uppercase" style="font-size: 0.65rem; color: #94A3B8;">Get it on</span>
                                <strong class="text-white">Google Play Store</strong>
                            </div>
                        </a>
                        <a href="{{ route('landing.download') }}" class="btn btn-dark text-start d-flex align-items-center gap-3 p-2 rounded-3 border border-secondary border-opacity-25">
                            <i class="bi bi-apple fs-3 text-white"></i>
                            <div>
                                <span class="d-block text-uppercase" style="font-size: 0.65rem; color: #94A3B8;">Download on the</span>
                                <strong class="text-white">Apple App Store</strong>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted">
                    &copy; {{ date('Y') }} <strong>{{ $setting->webname ?? 'Movers Logistics' }}</strong>. All Rights Reserved. Built for Pakistan Freight Industry.
                </div>
                <div class="d-flex gap-4">
                    <a href="{{ route('landing.terms') }}" class="text-muted text-decoration-none small">Terms of Service</a>
                    <a href="{{ route('landing.privacy') }}" class="text-muted text-decoration-none small">Privacy Policy</a>
                    <a href="{{ route('landing.contact') }}" class="text-muted text-decoration-none small">Support Helpdesk</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Layout Scripts -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.main-navbar');
            if (window.scrollY > 40) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Scroll to top button visibility
            const scrollBtn = document.getElementById('scrollTopBtn');
            if (window.scrollY > 400) {
                scrollBtn.style.display = 'flex';
            } else {
                scrollBtn.style.display = 'none';
            }
        });

        // Scroll to top handler
        document.getElementById('scrollTopBtn').addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
    @yield('scripts')
</body>
</html>
