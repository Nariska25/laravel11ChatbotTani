<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
    @include('admin.partials.header') <!-- Memanggil header -->
    
    <div class="container-fluid">
        @yield('content') <!-- Konten utama akan ditampilkan di sini -->
    </div>

    @include('admin.partials.footer') <!-- Memanggil footer -->
    <!-- Bootstrap Bundle JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('admin/js/bootstrap-admin.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom-admin.js') }}"></script>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins (if needed) -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script> --}}

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
