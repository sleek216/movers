<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Movers Freight & Logistics') }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --primary-light: #EEF2FF;
            --secondary: #64748B;
            --dark-sidebar: #0F172A;
            --sidebar-active: #1E293B;
            --sidebar-text: #94A3B8;
            --sidebar-text-hover: #F8FAFC;
            --bg-body: #F8FAFC;
            --card-border: #E2E8F0;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-card: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
            --shadow-hover: 0 10px 25px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.04);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Layout Structure */
        .app-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling */
        .app-sidebar {
            width: 270px;
            background-color: var(--dark-sidebar);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
        }

        .sidebar-brand {
            padding: 24px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        .brand-badge {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px 14px;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .nav-category {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748B;
            padding: 18px 12px 6px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-item a.nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .nav-item a.nav-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
            color: #64748B;
            transition: color 0.2s ease;
        }

        .nav-item a.nav-link:hover {
            color: var(--sidebar-text-hover);
            background-color: var(--sidebar-active);
        }
        .nav-item a.nav-link:hover i {
            color: #A5B4FC;
        }

        .nav-item a.nav-link.active {
            color: #FFFFFF;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }
        .nav-item a.nav-link.active i {
            color: #FFFFFF;
        }

        /* Main Content Wrapper */
        .app-main {
            flex: 1;
            margin-left: 270px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: all 0.3s ease;
            width: calc(100% - 270px);
        }

        /* Topbar Header */
        .app-header {
            height: 72px;
            background-color: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .toggle-sidebar-btn {
            background: transparent;
            border: 1px solid var(--card-border);
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .toggle-sidebar-btn:hover {
            background-color: var(--bg-body);
            color: var(--primary);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: transparent;
            border: none;
            padding: 4px;
            cursor: pointer;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4F46E5 0%, #9333EA 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }

        /* Page Body */
        .app-body {
            flex: 1;
            padding: 28px;
        }

        /* Card Modern Styling */
        .card {
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            background-color: #FFFFFF;
            box-shadow: var(--shadow-card);
            transition: all 0.25s ease;
            margin-bottom: 24px;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--card-border);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h5 {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
            color: var(--text-main);
        }

        .card-body {
            padding: 24px;
        }

        /* Stat Widget Cards */
        .stat-card {
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            background-color: #FFFFFF;
            box-shadow: var(--shadow-card);
            padding: 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            border-color: #CBD5E1;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .stat-icon.primary { background-color: #EEF2FF; color: #4F46E5; }
        .stat-icon.success { background-color: #ECFDF5; color: #10B981; }
        .stat-icon.warning { background-color: #FFFBEB; color: #F59E0B; }
        .stat-icon.info { background-color: #F0F9FF; color: #0EA5E9; }
        .stat-icon.danger { background-color: #FEF2F2; color: #EF4444; }

        .stat-title {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
        }

        /* Table Design */
        .table-responsive {
            border-radius: var(--radius-md);
        }
        table.table {
            margin-bottom: 0;
            color: var(--text-main);
            vertical-align: middle;
        }
        table.table thead th {
            background-color: #F8FAFC;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--card-border);
            padding: 14px 18px;
            white-space: nowrap;
        }
        table.table tbody td {
            padding: 16px 18px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.92rem;
        }
        table.table tbody tr:hover {
            background-color: #F8FAFC;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }
        .badge-soft-success { background-color: #D1FAE5; color: #065F46; }
        .badge-soft-danger { background-color: #FEE2E2; color: #991B1B; }
        .badge-soft-warning { background-color: #FEF3C7; color: #92400E; }
        .badge-soft-info { background-color: #E0F2FE; color: #075985; }
        .badge-soft-primary { background-color: #EEF2FF; color: #3730A3; }

        /* Buttons */
        .btn {
            font-weight: 600;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 0.88rem;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.82rem;
        }

        /* Footer */
        .app-footer {
            padding: 20px 28px;
            background-color: #FFFFFF;
            border-top: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1030;
            display: none;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
            }
            .app-sidebar.show {
                transform: translateX(0);
            }
            .app-main {
                margin-left: 0;
                width: 100%;
            }
            .sidebar-overlay.show {
                display: block;
            }
            .app-body {
                padding: 18px 14px;
            }
            .app-header {
                padding: 0 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Backdrop for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar Navigation -->
        <aside class="app-sidebar" id="appSidebar">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}">
                    <div class="brand-badge"><i class="bi bi-truck"></i></div>
                    <span>MOVERS</span>
                </a>
                <button class="btn btn-sm text-secondary d-lg-none p-0" onclick="toggleSidebar()">
                    <i class="bi bi-x-lg fs-5"></i>
                </button>
            </div>

            <div class="sidebar-content">
                <div class="nav-category">Main Menu</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-category">Users & Fleet</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i>
                            <span>Customers (Users)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.owners.index') }}" class="nav-link {{ request()->routeIs('admin.owners.*') ? 'active' : '' }}">
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Transporters (Owners)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.drivers.index') }}" class="nav-link {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Drivers List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.lorries.index') }}" class="nav-link {{ request()->routeIs('admin.lorries.*') ? 'active' : '' }}">
                            <i class="bi bi-truck-front-fill"></i>
                            <span>Trucks / Lorries</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.vehicles.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                            <i class="bi bi-boxes"></i>
                            <span>Vehicle Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.calculator.index') }}" class="nav-link {{ request()->routeIs('admin.calculator.*') ? 'active' : '' }}">
                            <i class="bi bi-calculator-fill"></i>
                            <span>Route & Rates Matrix</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-category">Loads & Bookings</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.loads.index') }}" class="nav-link {{ request()->is('*/loads') ? 'active' : '' }}">
                            <i class="bi bi-box-seam-fill"></i>
                            <span>All Loads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.loads.byStatus', 'Pending') }}" class="nav-link {{ request()->is('*/loads/Pending') ? 'active' : '' }}">
                            <i class="bi bi-clock-history"></i>
                            <span>Pending Loads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.loads.byStatus', 'Accepted') }}" class="nav-link {{ request()->is('*/loads/Accepted') ? 'active' : '' }}">
                            <i class="bi bi-check2-circle"></i>
                            <span>Accepted Loads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.loads.byStatus', 'Pickup') }}" class="nav-link {{ request()->is('*/loads/Pickup') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>In-Pickup Loads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.loads.byStatus', 'Complete') }}" class="nav-link {{ request()->is('*/loads/Complete') ? 'active' : '' }}">
                            <i class="bi bi-patch-check-fill"></i>
                            <span>Completed Loads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.loads.byStatus', 'Cancelled') }}" class="nav-link {{ request()->is('*/loads/Cancelled') ? 'active' : '' }}">
                            <i class="bi bi-x-circle-fill"></i>
                            <span>Cancelled Loads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.bilties.index') }}" class="nav-link {{ request()->routeIs('admin.bilties.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text-fill text-warning"></i>
                            <span>Digital Bilty Register</span>
                            <span class="badge bg-primary ms-auto" style="font-size: 0.65rem;">KYC</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.communities.index') }}" class="nav-link {{ request()->routeIs('admin.communities.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-square-quote-fill text-info"></i>
                            <span>Movers Communities</span>
                            <span class="badge bg-success ms-auto" style="font-size: 0.65rem;">Hubs</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-category">Finance & Revenue</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.payouts.index') }}" class="nav-link {{ request()->routeIs('admin.payouts.index') ? 'active' : '' }}">
                            <i class="bi bi-wallet2"></i>
                            <span>Transporter Payouts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.payouts.earnings') }}" class="nav-link {{ request()->routeIs('admin.payouts.earnings') ? 'active' : '' }}">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>Earning Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                            <i class="bi bi-credit-card-2-front-fill"></i>
                            <span>Payment Gateways</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-category">App Configuration</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                            <i class="bi bi-images"></i>
                            <span>Banners</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.states.index') }}" class="nav-link {{ request()->routeIs('admin.states.*') ? 'active' : '' }}">
                            <i class="bi bi-map-fill"></i>
                            <span>States</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.country_codes.index') }}" class="nav-link {{ request()->routeIs('admin.country_codes.*') ? 'active' : '' }}">
                            <i class="bi bi-telephone-fill"></i>
                            <span>Country Codes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                            <i class="bi bi-question-circle-fill"></i>
                            <span>FAQs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <span>Dynamic Pages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                            <i class="bi bi-sliders"></i>
                            <span>App Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.profile') }}" class="nav-link {{ request()->routeIs('admin.settings.profile') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Admin Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="app-main">
            <!-- Header Topbar -->
            <header class="app-header">
                <div class="header-left">
                    <button class="toggle-sidebar-btn d-lg-none" onclick="toggleSidebar()">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h6 class="mb-0 fw-bold d-none d-md-block">Movers Admin Panel</h6>
                        <small class="text-muted d-none d-md-block">Control & Management Dashboard</small>
                    </div>
                </div>

                <div class="header-right">
                    <div class="dropdown">
                        <button class="user-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}
                            </div>
                            <div class="text-start d-none d-sm-block">
                                <div class="fw-bold fs-6 lh-1">{{ session('admin_user', 'Admin') }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">Super Admin</small>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: var(--radius-md); min-width: 200px;">
                            <li><a class="dropdown-item py-2" href="{{ route('admin.settings.profile') }}"><i class="bi bi-person me-2 text-primary"></i> Profile & Security</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2 text-primary"></i> App Settings</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content Body -->
            <main class="app-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: var(--radius-md);">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div><strong>Success!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: var(--radius-md);">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div><strong>Error!</strong> {{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: var(--radius-md);">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="app-footer">
                <div>Copyright © {{ date('Y') }} <strong>Movers Freight & Logistics</strong>. All rights reserved.</div>
                <div>Unified Laravel 11 Backend & REST API Engine</div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('appSidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records..."
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
