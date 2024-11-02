@extends('partials.main')
@section('title', 'Dashboard')
@push('chart')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
@section('main')
    <div class="pc-content">
        <div class="row">
            <!-- Card Jumlah Obat -->
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-primary order-card">
                    <div class="card-body">
                        <h6 class="text-white">Jumlah Obat</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-pills float-start"></i>
                            <span>{{ $total_obat }}</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Card Total Penjualan -->
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-success order-card">
                    <div class="card-body">
                        <h6 class="text-white">Total Penjualan</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-cart-shopping float-start"></i>
                            <span>{{ $total_penjualan }}</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Card Total Prediksi -->
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-warning order-card">
                    <div class="card-body">
                        <h6 class="text-white">Total Prediksi</h6>
                        <h2 class="text-end text-white">
                            <i class="fa-solid fa-chart-line float-start"></i>
                            <span>{{ $total_prediksi }}</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Grafik Penjualan Bulanan -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Penjualan Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <div id="monthlySalesChart"></div>
                    </div>
                </div>
            </div>

            <!-- Grafik Prediksi -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Perbandingan Aktual vs Prediksi</h5>
                    </div>
                    <div class="card-body">
                        <div id="predictionChart"></div>
                    </div>
                </div>
            </div>

            <script>
                // Grafik Penjualan Bulanan
                var monthlySalesData = @json($monthly_sales);
                var processedData = monthlySalesData.reduce((acc, item) => {
                    if (!acc[item.year]) {
                        acc[item.year] = Array(12).fill(null);
                    }
                    acc[item.year][item.month - 1] = item.total_quantity;
                    return acc;
                }, {});

                var years = Object.keys(processedData);
                var series = years.map(year => ({
                    name: year,
                    data: processedData[year]
                }));

                var monthlySalesOptions = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: true
                        }
                    },
                    series: series,
                    colors: ['#4099ff', '#2ed8b6', '#FFB64D'],
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val !== null ? val.toFixed(0) : '';
                        }
                    },
                    stroke: {
                        width: 2,
                        curve: 'straight',
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                        title: {
                            text: 'Bulan'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Total Penjualan'
                        }
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                    },
                    legend: {
                        position: 'top'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var monthlySalesChart = new ApexCharts(document.querySelector("#monthlySalesChart"), monthlySalesOptions);
                monthlySalesChart.render();

                // Grafik Prediksi
                var predictionData = @json($prediction_data);
                var predictionOptions = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: true
                        }
                    },
                    colors: ['#4099ff', '#2ed8b6'],
                    series: [{
                        name: 'Data Aktual',
                        data: predictionData.actual
                    }, {
                        name: 'Hasil Prediksi',
                        data: predictionData.prediction
                    }],
                    stroke: {
                        width: [4, 4],
                        curve: 'straight'
                    },
                    xaxis: {
                        categories: predictionData.periods,
                        title: {
                            text: 'Periode'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Permintaan'
                        }
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                    },
                    legend: {
                        position: 'top'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var predictionChart = new ApexCharts(document.querySelector("#predictionChart"), predictionOptions);
                predictionChart.render();
            </script>
        </div>
    </div>
@endsection