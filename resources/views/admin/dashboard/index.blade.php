@extends('partials.main')
@section('title', 'Dashboard')
@push('chart')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        .order-card {
            transition: all 0.3s ease-in-out;
        }
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(121, 16, 16, 0.3);
        }
        .card-stats {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .bg-grd-primary { background: linear-gradient(45deg, #03cc50, #73b4ff); }
        .bg-grd-success { background: linear-gradient(45deg, #2ed8b6, #59e0c5); }
        .bg-grd-warning { background: linear-gradient(45deg, #FFB64D, #ffcb80); }
        .bg-grd-danger { background: linear-gradient(45deg, #FF5370, #ff869a); }
    </style>
@endpush

@section('main')
    <div class="pc-content">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-2">DASHBOARD METODE DES</h2>
                <p class="text-muted">Monitoring Prediksi Produk Pertanian UD. Dison</p>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-primary order-card card-stats">
                    <div class="card-body">
                        <h6 class="text-white">Jumlah Produk</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-pills float-start"></i>
                            <span>{{ number_format($total_obat) }}</span>
                        </h2>
                        <p class="text-white-50 mb-0">Total Jenis Produk Tersedia</p>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-success order-card card-stats">
                    <div class="card-body">
                        <h6 class="text-white">Total Penjualan</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-cart-shopping float-start"></i>
                            <span>{{ number_format($total_penjualan) }}</span>
                        </h2>
                        <p class="text-white-50 mb-0">Transaksi {{ $current_month }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-warning order-card card-stats">
                    <div class="card-body">
                        <h6 class="text-white">Prediksi DES</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-chart-line float-start"></i>
                            <span>{{ number_format($total_prediksi) }}</span>
                        </h2>
                        <p class="text-white-50 mb-0">Total Hasil Prediksi</p>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-danger order-card card-stats">
                    <div class="card-body">
                        <h6 class="text-white">Stok Warning</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-triangle-exclamation float-start"></i>
                            <span>{{ number_format($stok_warning) }}</span>
                        </h2>
                        <p class="text-white-50 mb-0">Obat Stok Minimum</p>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Charts -->
        {{-- <div class="row mt-4">
            <!-- Monthly Sales Chart -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Trend Penjualan Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <div id="monthlySalesChart"></div>
                    </div>
                </div>
            </div>

            <!-- Prediction Chart -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Perbandingan Data Aktual vs Prediksi</h5>
                    </div>
                    <div class="card-body">
                        <div id="predictionChart"></div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Charts Script -->
        <script>
            // Monthly Sales Chart
            var monthlySalesOptions = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Total Penjualan',
                    data: @json($monthly_sales->pluck('total_quantity'))
                }],
                xaxis: {
                    categories: @json($monthly_sales->pluck('periode')),
                    labels: {
                        rotate: -45,
                        rotateAlways: true
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Penjualan'
                    },
                    min: 0
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                colors: ['#4099ff'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3
                    }
                }
            };

            // Prediction Chart
            var predictionOptions = {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Data Aktual',
                    data: @json($prediction_data['actual'])
                }, {
                    name: 'Hasil Prediksi',
                    data: @json($prediction_data['prediction'])
                }],
                xaxis: {
                    categories: @json($prediction_data['periods']),
                    labels: {
                        rotate: -45,
                        rotateAlways: true
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah'
                    },
                    min: 0
                },
                colors: ['#2ed8b6', '#4099ff'],
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 4
                },
                legend: {
                    position: 'top'
                }
            };

            // Render Charts
            new ApexCharts(document.querySelector("#monthlySalesChart"), monthlySalesOptions).render();
            new ApexCharts(document.querySelector("#predictionChart"), predictionOptions).render();

            // Debug
            console.log('Monthly Sales:', @json($monthly_sales));
            console.log('Prediction Data:', @json($prediction_data));
        </script>
    </div>
@endsection
