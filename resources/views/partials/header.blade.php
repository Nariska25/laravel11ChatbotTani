<!-- resources/views/partials/header.blade.php -->

<!-- Spinner Start -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->

<!-- Navbar Start -->
<div class="container-fluid fixed-top">
    <!-- Topbar -->
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3">
                    <i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                    <a href="#" class="text-white">Samplangan, Kabupaten Gianyar</a>
                </small>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/agriculture.jpg') }}" class="img-fluid rounded" alt="logo" style="max-height: 50px; object-fit: cover;">
                <h1 class="text-primary display-6 ms-3 mb-0">Sahabat Tani</h1>
            </div>       
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="/home" class="nav-item nav-link active">Home</a>
                    <a href="/shop" class="nav-item nav-link">Products</a>
                    <a href="contact.html" class="nav-item nav-link">Contact</a>
                </div>
                <div class="d-flex m-3 me-0">
                <div class="d-flex m-3 me-0">
                    
                        <!-- Tombol Keranjang -->
                        <a href="{{ route('cart.index') }}" class="position-relative me-3 my-auto">
                            <i class="fa fa-shopping-bag fa-2x text-primary"></i>
                            <span class="position-absolute d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"></span>
                        </a>
                    
                        <!-- Ikon Login atau Logout -->
                        @if (auth()->check())
                            <a href="{{ route('logout') }}" class="my-auto"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-user fa-2x"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="my-auto">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                        @endif
                    </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
