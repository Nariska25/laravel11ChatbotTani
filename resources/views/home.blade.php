@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
  <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @foreach([1, 2, 3, 4, 5] as $key => $slide)
        <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></button>
      @endforeach
    </div>
    <div class="carousel-inner">
      @foreach([1, 2, 3, 4, 5] as $key => $slide)
      <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
        <div class="carousel-image-wrapper position-relative">
          <img src="{{ asset("assets/img/hero-$slide.jpg") }}" class="d-block mx-auto hero-img" style="width: 100%; height: 100vh; object-fit: cover;" alt="Hero Image {{ $slide }}" loading="lazy">
          <div class="carousel-caption container position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-center px-4 px-md-5">
            <div class="hero-content text-white d-flex flex-column align-items-center gap-4" style="max-width: 800px;">
              <h2 class="hero-title display-3 fw-bold">
                @if($slide === 1) Ketahanan Pangan Dunia
                @elseif($slide === 2) Sayuran Organik Tanpa Pestisida
                @elseif($slide === 3) Hasil Panen Segar Setiap Hari
                @elseif($slide === 4) Pertanian Berbasis Teknologi
                @else Pangan Berkualitas untuk Semua @endif
              </h2>
              <p class="hero-text lead">
                @if($slide === 1) Inovasi dan teknologi memenuhi kebutuhan pangan global secara berkelanjutan.
                @elseif($slide === 2) Tanaman organik tanpa bahan kimia menghasilkan makanan sehat.
                @elseif($slide === 3) Hasil pertanian segar setiap hari.
                @elseif($slide === 4) Pertanian modern untuk generasi mendatang.
                @else Dukung pertanian lokal untuk kehidupan sehat. @endif
              </p>
              <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-1 fw-bold text-white shadow">
                <i class="fas fa-shopping-basket me-2"></i> Explore Produk
              </a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>
</section>

<!-- Features Section -->
<section id="features" class="features-section py-5 py-lg-7 bg-white">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-subtitle text-success fw-bold mb-2 d-block">TEKNOLOGI MODERN</span>
      <h2 class="section-title display-5 fw-bold mb-3">Metode Penanaman Unggulan</h2>
      <p class="section-description lead text-muted mx-auto" style="max-width: 700px;">Teknik modern untuk hasil panen optimal</p>
    </div>
    <div class="row g-4 g-lg-5">
      @foreach([
        ['icon' => 'planting.png', 'title' => 'Penanaman Presisi', 'desc' => 'Teknik penanaman dengan akurasi tinggi'],
        ['icon' => 'mulching.png', 'title' => 'Pelapisan Mulsa', 'desc' => 'Manajemen kelembaban tanah'],
        ['icon' => 'plowing.png', 'title' => 'Pengolahan Tanah', 'desc' => 'Pengolahan tanah modern'],
        ['icon' => 'mowing.png', 'title' => 'Pemangkasan', 'desc' => 'Pemeliharaan tanaman terpadu'],
        ['icon' => 'seed.png', 'title' => 'Penyemaian', 'desc' => 'Penyemaian terkontrol'],
        ['icon' => 'watering.png', 'title' => 'Irigasi Presisi', 'desc' => 'Irigasi 4.0 otomatis'],
      ] as $feature)
      <div class="col-md-6 col-lg-4">
        <div class="feature-card p-4 bg-white rounded-4 shadow-sm h-100">
          <div class="icon-wrapper bg-success bg-opacity-10 rounded-3 p-3 mb-4">
            <img src="{{ asset("assets/img/{$feature['icon']}") }}" alt="{{ $feature['title'] }}" class="img-fluid" width="40">
          </div>
          <h3 class="h4 fw-bold mb-3">{{ $feature['title'] }}</h3>
          <p class="text-muted mb-0">{{ $feature['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Promo Section -->
<section class="promo-section py-5 py-lg-7 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="image-wrapper position-relative rounded-4 overflow-hidden shadow">
          <img src="{{ asset('assets/img/farm3.jpg') }}" alt="Special Offer" class="img-fluid rounded-4">
          <div class="promo-badge bg-danger text-white fw-bold py-2 px-4 rounded-pill position-absolute top-0 start-0 m-4">
            Limited Offer!
          </div>
        </div>
      </div>
      <div class="col-lg-6 ps-lg-5">
        <h2 class="display-5 fw-bold mb-4">Bibit Kopi Premium<br><span class="text-danger">Diskon 50%</span></h2>
        <p class="lead mb-5">Dapatkan bibit kopi unggulan dengan harga spesial bulan ini!</p>
        <div class="d-flex flex-wrap align-items-center gap-4">
          <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg px-5 py-3 rounded-1 fw-bold">
            <i class="fas fa-shopping-cart me-2"></i> Beli Sekarang
          </a>
          <div class="price-info">
            <div class="text-danger h2 mb-0 fw-bold">Rp10.000</div>
            <del class="text-muted">Rp20.000</del>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Products Section -->
<section class="products-section py-5 py-lg-7 bg-white">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-subtitle text-success fw-bold mb-2 d-block">PRODUK TERBAIK</span>
      <h2 class="section-title display-5 fw-bold mb-3">Produk Unggulan Kami</h2>
      <p class="section-description lead text-muted mx-auto" style="max-width: 700px;">Temukan produk berkualitas tinggi untuk kebutuhan Anda</p>
    </div>

    <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @foreach($featuredProducts->chunk(4) as $chunk)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
          <div class="row g-4">
            @foreach($chunk as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
              <div class="product-card bg-white rounded-4 shadow-sm h-100">
                <div class="product-image position-relative">
                  <img src="{{ asset('storage/' . $product->products_image) }}" class="product-img img-fluid w-100" alt="{{ $product->products_name }}" style="height: 200px; object-fit: cover;">
                  @if ($product->sale)
                    <div class="product-badge bg-danger text-white py-1 px-3 position-absolute top-0 end-0 m-3 rounded-pill small">
                      Sale {{ $product->discount_percentage }}%
                    </div>
                  @endif
                </div>
                <div class="product-details p-4 d-flex flex-column">
                  <h5 class="product-title fw-semibold mb-2">{{ $product->products_name }}</h5>
                  <div class="price-wrapper mb-3">
                    @if ($product->sale)
                      <span class="original-price text-decoration-line-through text-muted me-2">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                      <span class="discounted-price text-danger fw-bold">Rp{{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                    @else
                      <span class="current-price fw-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                  </div>
                  <div class="product-actions d-flex gap-2">
                    <a href="{{ route('detail', ['id' => $product->products_id]) }}" class="btn btn-outline-success btn-sm w-100 py-2">
                      <i class="fas fa-eye me-2"></i> Detail
                    </a>
                    <form action="{{ route('cart.store') }}" method="POST" class="w-100">
                      @csrf
                      <input type="hidden" name="products_id" value="{{ $product->products_id }}">
                      <button type="submit" class="btn btn-success btn-sm w-100 py-2">
                        <i class="fas fa-cart-plus me-2"></i> Beli
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endforeach
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark bg-opacity-25 rounded-circle p-3" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark bg-opacity-25 rounded-circle p-3" aria-hidden="true"></span>
      </button>
    </div>

    <div class="text-center mt-5">
      <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg px-5 py-3 rounded-1 fw-bold">
        <i class="fas fa-store me-2"></i> Lihat Semua Produk
      </a>
    </div>
  </div>
</section>
@endsection
