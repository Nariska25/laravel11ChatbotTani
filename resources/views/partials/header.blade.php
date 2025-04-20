<!-- resources/views/partials/header.blade.php -->

<!-- resources/views/partials/header.blade.php -->

<!-- Spinner Start -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center" style="z-index: 9999;">
    <div class="spinner-grow text-success" role="status" style="width: 3rem; height: 3rem;"></div>
</div>
<!-- Spinner End -->

<!-- Navbar Start -->
<header id="navbar" class="container-fluid fixed-top bg-white" style="z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-bottom: 1px solid rgba(0,0,0,0.05);">
    <div class="container px-0">
        <nav class="navbar navbar-expand-lg bg-white py-3">
            <!-- Logo and Brand Name -->
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid rounded" alt="Sahabat Tani Logo" style="width: 140px; height: auto;">
                <h1 class="text-success ms-3 mb-0 fw-bold" style="font-size: 1.8rem; font-family: 'Poppins', sans-serif; letter-spacing: -0.5px;">
                    Sahabat <span style="color: #2e8b57;">Tani</span>
                </h1>
            </a>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto align-items-center">
                    <!-- Menu Items -->
                    <div class="d-flex align-items-center me-4">
                        <!-- Home Link -->
                        <a href="{{ route('home') }}" 
                           class="nav-item nav-link mx-2 px-4 py-2 position-relative {{ request()->routeIs('home') ? 'text-success fw-bold' : 'text-dark' }}">
                            <span>Home</span>
                            <span class="position-absolute bottom-0 start-50 translate-middle-x bg-success" style="height: 3px; width: 0; transition: width 0.3s ease;"></span>
                        </a>

                        <!-- Products Link -->
                        <a href="{{ route('shop.index') }}" 
                           class="nav-item nav-link mx-2 px-4 py-2 position-relative {{ request()->routeIs('shop.index') ? 'text-success fw-bold' : 'text-dark' }}">
                            <span>Products</span>
                            <span class="position-absolute bottom-0 start-50 translate-middle-x bg-success" style="height: 3px; width: 0; transition: width 0.3s ease;"></span>
                        </a>

                        <!-- Order Link -->
                        <a href="{{ route('orders.index') }}" 
                           class="nav-item nav-link mx-2 px-4 py-2 position-relative {{ request()->routeIs('orders.index') ? 'text-success fw-bold' : 'text-dark' }}">
                            <span>Order</span>
                            <span class="position-absolute bottom-0 start-50 translate-middle-x bg-success" style="height: 3px; width: 0; transition: width 0.3s ease;"></span>
                        </a>
                    </div>

                    <!-- Icons Group -->
                    <div class="d-flex align-items-center ms-2">
                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="position-relative me-4 text-decoration-none" aria-label="Cart">
                            <div class="icon-wrapper" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: rgba(25, 135, 84, 0.1); border-radius: 50%; transition: all 0.3s;">
                                <i class="fa fa-shopping-bag fa-lg text-success"></i>
                            </div>
                            @if(session('cart_count', 0) > 0)
                                <span class="position-absolute bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" 
                                    style="top: -5px; right: -5px; height: 22px; min-width: 22px; font-size: 0.75rem; border: 2px solid white;">
                                    {{ session('cart_count', 0) }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown (Profile & Logout) -->
                        @auth
                            <div class="dropdown">
                                <a class="nav-link p-0" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="icon-wrapper" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: rgba(25, 135, 84, 0.1); border-radius: 50%; transition: all 0.3s;">
                                        <i class="fas fa-user fa-lg text-success"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-2 p-2 border-0 shadow-lg" aria-labelledby="userDropdown" style="min-width: 200px; border-radius: 12px;">
                                    <li>
                                        <a class="dropdown-item rounded-3 p-3 d-flex align-items-center" href="{{ route('profile.show') }}">
                                            <i class="fas fa-user-circle me-3 text-success"></i>
                                            <div>
                                                <div class="fw-bold">Profile</div>
                                                <small class="text-muted">View your account</small>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <a class="dropdown-item rounded-3 p-3 d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-3 text-danger"></i>
                                            <div>
                                                <div class="fw-bold">Logout</div>
                                                <small class="text-muted">Sign out safely</small>
                                            </div>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Login Link -->
                            <a href="{{ route('login') }}" class="ms-3 text-decoration-none">
                                <button class="btn btn-success px-4 py-2 rounded-pill fw-bold" style="background: linear-gradient(135deg, #2e8b57, #3cb371); border: none;">
                                    <i class="fas fa-user me-2"></i> Login
                                </button>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- Navbar End -->

<style>
    /* Import Google Font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    
    /* Base Styles */
    body {
        font-family: 'Poppins', sans-serif;
    }
    
    /* Navbar Hover Effects */
    .nav-item.nav-link {
        position: relative;
        transition: color 0.3s ease;
    }
    
    .nav-item.nav-link:hover {
        color: #2e8b57 !important;
    }
    
    .nav-item.nav-link:hover span:last-child {
        width: 60% !important;
    }
    
    .nav-item.nav-link.active span:last-child {
        width: 60% !important;
    }
    
    /* Icon Wrapper Hover */
    .icon-wrapper:hover {
        background: rgba(25, 135, 84, 0.2) !important;
        transform: translateY(-2px);
    }
    
    /* Dropdown Item Hover */
    .dropdown-item:hover {
        background-color: rgba(25, 135, 84, 0.05) !important;
    }
    
    /* Button Hover Effect */
    .btn-success:hover {
        box-shadow: 0 5px 15px rgba(46, 139, 87, 0.4);
        transform: translateY(-2px);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .navbar-nav {
            padding-top: 1rem;
        }
        
        .nav-item.nav-link {
            margin: 0.5rem 0 !important;
            padding-left: 1rem !important;
        }
        
        #navbarCollapse {
            padding-bottom: 1rem;
        }
        
        .d-flex.align-items-center.me-4 {
            margin-right: 0 !important;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }
        
        .d-flex.align-items-center.ms-2 {
            margin-left: 0 !important;
            margin-top: 1rem;
            width: 100%;
            justify-content: flex-start;
            padding-left: 1rem;
        }
    }
</style>