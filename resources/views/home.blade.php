@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
  <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @foreach([1,2,3,4,5] as $key => $slide)
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></button>
      @endforeach
    </div>
    <div class="carousel-inner">
      @foreach([1,2,3,4,5] as $key => $slide)
      <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
        <div class="carousel-image-wrapper position-relative">
          <img src="{{ asset("assets/img/hero-$slide.jpg") }}" class="d-block mx-auto hero-img" style="width: 100%; height: 100vh; object-fit: cover;" alt="Hero Image {{ $slide }}" loading="lazy">
          <div class="image-overlay position-absolute top-0 start-0 w-100 h-100"></div>

          <!-- Carousel Caption -->
          <div class="carousel-caption container position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-center px-4 px-md-5">
            <div class="hero-content animate__animated animate__fadeInUp text-white d-flex flex-column align-items-center gap-4" style="max-width: 800px;">

              <h2 class="hero-title display-3 fw-bold">
                @if($slide === 1)Ketahanan Pangan Dunia
                @elseif($slide === 2)Sayuran Organik Tanpa Pestisida
                @elseif($slide === 3)Hasil Panen Segar Setiap Hari
                @elseif($slide === 4)Pertanian Berbasis Teknologi
                @else Pangan Berkualitas untuk Semua @endif
              </h2>

              <p class="hero-text lead">
                @if($slide === 1)Dengan inovasi dan teknologi, pertanian modern dapat memenuhi kebutuhan pangan global secara berkelanjutan.
                @elseif($slide === 2)Tanaman organik tanpa bahan kimia berbahaya menghasilkan makanan sehat untuk keluarga dan bumi yang lebih hijau.
                @elseif($slide === 3)Dari ladang langsung ke meja makan Anda—kami menghadirkan hasil pertanian segar dan berkualitas setiap hari.
                @elseif($slide === 4)Gabungan metode tradisional dan teknologi modern menjadikan pertanian sebagai sektor menjanjikan bagi generasi mendatang.
                @else Dukung pertanian lokal dan nikmati hasil panen terbaik yang kaya nutrisi untuk kehidupan yang lebih sehat. @endif
              </p>
            </div>
          </div>

              <div class="d-flex flex-wrap justify-content-center gap-3 mt-2">
                <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-1 fw-bold text-white shadow">
                  <i class="fas fa-shopping-basket me-2"></i> Explore Produk
                </a>
              </div>
            </div>
      </div>
      @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
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
        ['icon' => 'planting.png', 'title' => 'Penanaman Presisi', 'desc' => 'Teknik penanaman dengan akurasi tinggi untuk pertumbuhan optimal'],
        ['icon' => 'mulching.png', 'title' => 'Pelapisan Mulsa', 'desc' => 'Manajemen kelembaban tanah profesional'],
        ['icon' => 'plowing.png', 'title' => 'Pengolahan Tanah', 'desc' => 'Pengolahan tanah berbasis teknologi modern'],
        ['icon' => 'mowing.png', 'title' => 'Pemangkasan', 'desc' => 'Sistem pemeliharaan tanaman terpadu'],
        ['icon' => 'seed.png', 'title' => 'Penyemaian', 'desc' => 'Proses penyemaian terkontrol kualitas'],
        ['icon' => 'watering.png', 'title' => 'Irigasi Presisi', 'desc' => 'Sistem irigasi 4.0 dengan pengaturan otomatis'],
      ] as $index => $feature)
      <div class="col-md-6 col-lg-4">
        <div class="feature-card p-4 p-lg-5 bg-white rounded-4 shadow-sm h-100 transition-all hover-shadow">
          <div class="icon-wrapper bg-success bg-opacity-10 rounded-3 p-3 mb-4" style="width: 80px; height: 80px;">
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
          <img src="{{ asset('assets/img/farm3.jpg') }}" alt="Special Offer" class="img-fluid rounded-4" loading="lazy">
          <div class="promo-badge bg-danger text-white fw-bold py-2 px-4 rounded-pill position-absolute top-0 start-0 m-4">
            Limited Offer!
          </div>
        </div>
      </div>
      <div class="col-lg-6 ps-lg-5">
        <span class="badge bg-success bg-opacity-10 text-success mb-3">PROMO KHUSUS</span>
        <h2 class="display-5 fw-bold mb-4">Bibit Kopi Premium<br><span class="text-danger">Diskon 50%</span></h2>
        <p class="lead mb-5">Dapatkan bibit kopi unggulan dengan kualitas ekspor dan harga spesial hanya untuk bulan ini!</p>
        
        <div class="feature-list mb-5">
          <div class="d-flex mb-4">
            <div class="icon-wrapper bg-success text-white rounded-circle me-4 flex-shrink-0" style="width: 50px; height: 50px; line-height: 50px; text-align: center;">
              <i class="fas fa-check fs-5"></i>
            </div>
            <div>
              <h4 class="h5 mb-2 fw-bold">Sertifikasi Internasional</h4>
              <p class="text-muted mb-0">Kualitas terjamin dengan sertifikasi Grade AA</p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="icon-wrapper bg-success text-white rounded-circle me-4 flex-shrink-0" style="width: 50px; height: 50px; line-height: 50px; text-align: center;">
              <i class="fas fa-seedling fs-5"></i>
            </div>
            <div>
              <h4 class="h5 mb-2 fw-bold">Bibit Unggul</h4>
              <p class="text-muted mb-0">Varietas Arabica dan Robusta dengan produktivitas tinggi</p>
            </div>
          </div>
        </div>

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
      <p class="section-description lead text-muted mx-auto" style="max-width: 700px;">Temukan produk pertanian berkualitas tinggi untuk kebutuhan Anda</p>
    </div>

    <!-- Carousel Wrapper -->
    <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @php $chunks = $featuredProducts->chunk(4); @endphp
        @foreach($chunks as $key => $chunk)
        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
          <div class="row g-4">
            @foreach($chunk as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
              <div class="product-card bg-white rounded-4 overflow-hidden shadow-sm h-100 transition-all hover-shadow">
                <div class="product-image position-relative overflow-hidden">
                  <img src="{{ asset('storage/' . $product->products_image) }}" 
                       class="product-img img-fluid w-100" 
                       alt="{{ $product->products_name }}"
                       loading="lazy"
                       style="height: 200px; object-fit: cover;">
                  @if ($product->sale)
                    <div class="product-badge bg-danger text-white py-1 px-3 position-absolute top-0 end-0 m-3 rounded-pill small">
                      Sale {{ $product->discount_percentage }}%
                    </div>
                  @endif
                </div>

                <div class="product-details p-4 d-flex flex-column justify-content-between">
                  <div>
                    <div class="product-category small text-muted mb-2">
                      {{ $product->category->category_name ?? 'Umum' }}
                    </div>
                
                    <h5 class="product-title fw-semibold mb-2" style="min-height: 40px;">
                      {{ $product->products_name }}
                    </h5>
                
                    <div class="price-wrapper mb-3">
                      @if ($product->sale)
                        <span class="original-price text-decoration-line-through text-muted me-2">
                          Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="discounted-price text-danger fw-bold">
                          Rp{{ number_format($product->discounted_price, 0, ',', '.') }}
                        </span>
                      @else
                        <span class="current-price fw-bold">
                          Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                      @endif
                    </div>
                  </div>

                  <div class="product-actions d-flex gap-2">
                    <form action="{{ route('detail', ['id' => $product->products_id]) }}" method="GET" class="w-100">
                      <button type="submit" class="btn btn-outline-success btn-sm w-100 py-2">
                        <i class="fas fa-eye me-2"></i> Detail
                      </button>
                    </form>
                    <form action="{{ route('cart.store') }}" method="POST" class="w-100">
                      @csrf
                      <input type="hidden" name="products_id" value="{{ $product->products_id }}">
                      <input type="hidden" name="amount" value="1">
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

      <!-- Carousel Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark bg-opacity-25 rounded-circle p-3" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark bg-opacity-25 rounded-circle p-3" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div class="text-center mt-5">
      <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg px-5 py-3 rounded-1 fw-bold">
        <i class="fas fa-store me-2"></i> Lihat Semua Produk
      </a>
    </div>
  </div>
</section>

<style>
  /* Carousel Custom Styles */
  .product-title {
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Maksimal 2 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 3em; /* Untuk menjaga tinggi konsisten walau teks pendek */
  }

  .product-card {
    display: flex;
    flex-direction: column;
  }

  .product-details {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  #productsCarousel {
    position: relative;
    padding: 0 30px;
  }
  
  .carousel-control-prev,
  .carousel-control-next {
    width: auto;
    opacity: 1;
  }
  
  .carousel-control-prev {
    left: -15px;
  }
  
  .carousel-control-next {
    right: -15px;
  }
  
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-size: 60%;
    width: 30px;
    height: 30px;
  }
  
  @media (max-width: 768px) {
    #productsCarousel {
      padding: 0;
    }
    
    .carousel-control-prev {
      left: 0;
    }
    
    .carousel-control-next {
      right: 0;
    }
  }
</style>