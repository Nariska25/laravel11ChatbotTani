<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-seedling"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Sahabat Tani</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Manajemen Produk</div>

        <!-- Produk -->
        <li class="nav-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.products.index') }}">
                <i class="fas fa-box-open"></i>
                <span>Produk</span>
            </a>
        </li>

        <!-- Kategori -->
        <li class="nav-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
        </li>

        <!-- Sale Section -->
        <li class="nav-item {{ request()->routeIs('admin.sales.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.sales.index') }}">
                <i class="fas fa-percent"></i>
                <span>Sale</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Manajemen Order</div>

        <!-- Order Section -->
        <li class="nav-item {{ request()->routeIs('admin.order.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.order.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Order</span>
            </a>
        </li>

        <!-- Voucher Section -->
        <li class="nav-item {{ request()->routeIs('admin.voucher.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.voucher.index') }}">
                <i class="fas fa-ticket-alt"></i>
                <span>Voucher</span>
            </a>
        </li>

        <!-- Pengiriman Section -->
        <li class="nav-item {{ request()->routeIs('admin.shipping.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.shipping.index') }}">
                <i class="fas fa-truck"></i>
                <span>Pengiriman</span>
            </a>
        </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- User Information -->
                    @if(Auth::check())
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('img/default-profile.png') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>

            </nav>
            <!-- End of Topbar -->