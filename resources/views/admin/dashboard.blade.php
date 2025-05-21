@extends('admin.layouts.app')

@section('content')

<h1>Dashboard Admin</h1>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row mt-2">

        <!-- Pendapatan (Monthly) Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendapatan Bulanan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp{{ number_format($monthlySales, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan (Tahunan) Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan Tahunan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp{{ number_format($annualSales, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Order Selesai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Order Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $completedOrders }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Order Belum Bayar Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Order Belum Bayar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingOrders }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content Row -->
    <div class="row mt-4">
        <!-- Grafik Penjualan Bulanan -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar mr-2"></i> Grafik Penjualan Bulanan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart Produk Terlaris -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Terlaris</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small" id="legend-container">
                        {{-- Legend akan diisi secara dinamis --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Grafik Penjualan Bulanan
    const labels = @json($labels);
    const data = @json($data);

    const areaCanvas = document.getElementById('myAreaChart');
    if (areaCanvas) {
        const ctx = areaCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nominal Penjualan',
                    data: data,
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // Data Produk Terlaris untuk Pie Chart
    const pieLabels = @json($pieLabels);
    const pieData = @json($pieData);
    const pieColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];

    const ctxPie = document.getElementById('myPieChart').getContext('2d');

    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: pieColors,
                hoverBackgroundColor: pieColors.map(c => c + 'cc'),
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            return `${label}: ${value} unit terjual`;
                        }
                    }
                },
                legend: {
                    display: false // Legend kita buat manual
                }
            },
            cutout: '60%'
        }
    });

    // Buat legend manual di bawah chart
    const legendContainer = document.getElementById('legend-container');
    if (legendContainer) {
        pieLabels.forEach((label, idx) => {
            const color = pieColors[idx];
            const span = document.createElement('span');
            span.style.marginRight = '10px';
            span.innerHTML = `<i class="fas fa-circle" style="color:${color}"></i> ${label}`;
            legendContainer.appendChild(span);
        });
    }
</script>
@endpush

@endsection
