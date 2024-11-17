@extends('partials.main')
@section('title', 'Hasil Prediksi DES')

@push('chart')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF(elementId) {
        // Get the element
        const element = document.getElementById(elementId);
        
        // Create a copy of the element
        const clonedTable = element.cloneNode(true);
        
        // Create a container for the PDF content
        const container = document.createElement('div');
        container.style.padding = '20px';
        container.style.backgroundColor = 'white';
        
        // Add title to the PDF
        const title = document.createElement('h4');
        title.style.marginBottom = '20px';
        title.style.textAlign = 'center';
        title.innerHTML = elementId === 'komponen-des' ? 'Komponen DES' : 'Perhitungan Error';
        container.appendChild(title);
        
        // Add the cloned table
        container.appendChild(clonedTable);
        
        // Add footer with date
        const footer = document.createElement('div');
        footer.style.marginTop = '20px';
        footer.style.textAlign = 'right';
        footer.style.fontSize = '12px';
        footer.innerHTML = 'Generated on: ' + new Date().toLocaleString();
        container.appendChild(footer);
    
        // Configure PDF options
        const opt = {
            margin: [0.5, 0.5, 0.5, 0.5],
            filename: `${elementId}-${new Date().toISOString().slice(0,10)}.pdf`,
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { 
                scale: 2,
                useCORS: true,
                letterRendering: true,
                windowWidth: element.scrollWidth
            },
            jsPDF: { 
                unit: 'in', 
                format: 'a4', 
                orientation: 'landscape',
                compress: false
            },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };
    
        // Style fixes before generating PDF
        const styleContent = `
            .table { width: 100% !important; margin-bottom: 0 !important; }
            .table th, .table td { 
                padding: 8px !important;
                font-size: 12px !important;
                border: 1px solid #dee2e6 !important;
            }
            .table thead th {
                background-color: #f8f9fa !important;
                font-weight: bold !important;
            }
            .badge {
                display: inline-block !important;
                padding: 4px 8px !important;
                font-size: 11px !important;
                border-radius: 4px !important;
            }
            .text-primary { color: #0d6efd !important; }
            .text-success { color: #198754 !important; }
            .text-info { color: #0dcaf0 !important; }
            .text-secondary { color: #6c757d !important; }
            .text-danger { color: #dc3545 !important; }
            .text-warning { color: #ffc107 !important; }
            .bg-primary-subtle { background-color: #cfe2ff !important; }
            .bg-success-subtle { background-color: #d1e7dd !important; }
            .bg-info-subtle { background-color: #cff4fc !important; }
            .bg-secondary-subtle { background-color: #e2e3e5 !important; }
            .bg-danger-subtle { background-color: #f8d7da !important; }
            .bg-warning-subtle { background-color: #fff3cd !important; }
        `;
    
        // Add style to container
        const style = document.createElement('style');
        style.textContent = styleContent;
        container.appendChild(style);
    
        // Generate PDF with loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.style.position = 'fixed';
        loadingDiv.style.top = '50%';
        loadingDiv.style.left = '50%';
        loadingDiv.style.transform = 'translate(-50%, -50%)';
        loadingDiv.style.padding = '20px';
        loadingDiv.style.background = 'rgba(0,0,0,0.7)';
        loadingDiv.style.color = 'white';
        loadingDiv.style.borderRadius = '10px';
        loadingDiv.style.zIndex = '9999';
        loadingDiv.innerHTML = 'Generating PDF...';
        document.body.appendChild(loadingDiv);
    
        // Generate PDF
        html2pdf()
            .set(opt)
            .from(container)
            .save()
            .then(() => {
                document.body.removeChild(loadingDiv);
            })
            .catch(err => {
                console.error('Error generating PDF:', err);
                document.body.removeChild(loadingDiv);
                alert('Terjadi kesalahan saat mengunduh PDF. Silakan coba lagi.');
            });
    }
    </script>
@endpush

@section('main')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block card mb-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title border-bottom pb-2 mb-2">
                            <h4 class="mb-0">Hasil Prediksi Permintaan Produk Pertanian {{ $prediksi }}</h4>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ph ph-house"></i></a></li>
                            <li class="breadcrumb-item">Prediksi</li>
                            <li class="breadcrumb-item active">Hasil Prediksi DES</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
       <!-- Parameter DES Card -->
<div class="col-md-6">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white border-bottom border-light py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-sliders2 text-primary fs-4"></i>
                    <h5 class="card-title mb-0 fw-semibold">Parameter DES</h5>
                </div>
                @if(isset($is_auto_parameter))
                <span class="badge rounded-pill px-3 py-2 {{ $is_auto_parameter ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info' }}">
                    <i class="bi {{ $is_auto_parameter ? 'bi-gear-fill' : 'bi-hand-index' }} me-1"></i>
                    {{ $is_auto_parameter ? 'Parameter Otomatis (Optimal)' : 'Parameter Manual' }}
                </span>
                @endif
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Alpha Parameter -->
                <div class="col-6">
                    <div class="border rounded-3 p-3 bg-light-subtle position-relative h-100 parameter-card">
                        <div class="parameter-icon text-primary-subtle">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3 class="display-6 fw-bold mb-1 text-primary">{{ $alpha }}</h3>
                        <div class="mb-1">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-2">Alpha <i>α</i> (Level)</span>
                        </div>
                        <small class="text-muted d-block">Smoothing Factor</small>
                    </div>
                </div>

                <!-- Beta Parameter -->
                <div class="col-6">
                    <div class="border rounded-3 p-3 bg-light-subtle position-relative h-100 parameter-card">
                        <div class="parameter-icon text-success-subtle">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3 class="display-6 fw-bold mb-1 text-success">{{ $beta }}</h3>
                        <div class="mb-1">
                            <span class="badge bg-success-subtle text-success rounded-pill px-2">Beta β (Trend)</span>
                        </div>
                        <small class="text-muted d-block">Trend Factor</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light-subtle border-top border-light py-3">
            <small class="text-muted d-flex align-items-center">
                <i class="bi bi-info-circle me-2"></i>
                Parameter yang digunakan dalam perhitungan Double Exponential Smoothing
            </small>
        </div>
    </div>
</div>

<style>
.parameter-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.parameter-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.08);
}

.parameter-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    opacity: 0.2;
}

.parameter-card:hover .parameter-icon {
    opacity: 0.4;
}
</style>

        <!-- Accuracy Metrics Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Akurasi Prediksi DES Produk {{ $prediksi }}</h5>
                    <div class="row g-4">
                        <!-- MAPE Display -->
                        <div class="col-6">
                            @php
                                $mape = $count > 0 ? $totalApe / $count : 0;
                                $accuracyClass = $mape <= 10 ? 'success' : ($mape <= 20 ? 'info' : ($mape <= 50 ? 'warning' : 'danger'));
                                $statusText = $mape <= 10 ? 'Sangat Baik' : ($mape <= 20 ? 'Baik' : ($mape <= 50 ? 'Cukup' : 'Rendah'));
                                $iconClass = $mape <= 10 ? 'bi-check-circle-fill' : ($mape <= 20 ? 'bi-hand-thumbs-up-fill' : ($mape <= 50 ? 'bi-exclamation-circle-fill' : 'bi-x-circle-fill'));
                            @endphp
                            
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <h6 class="text-secondary fw-semibold mb-4">
                                            <i class="bi bi-graph-up me-2"></i>
                                            MAPE (Mean Absolute Percentage Error)
                                        </h6>
                                        
                                        <!-- Circular Progress -->
                                        <div class="position-relative d-inline-block">
                                            <div class="progress rounded-circle" style="width: 150px; height: 150px;">
                                                <div class="progress-bar bg-{{ $accuracyClass }}" role="progressbar" 
                                                     style="width: {{ min($mape, 100) }}%" 
                                                     aria-valuenow="{{ $mape }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                                <h3 class="fw-bold text-{{ $accuracyClass }} mb-0" style="font-size: 2rem;">
                                                    {{ number_format($mape, 2) }}%
                                                </h3>
                                                <small class="text-muted">MAPE</small>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <!-- Status & Accuracy -->
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="p-3 rounded-4 bg-{{ $accuracyClass }}-subtle text-center h-100">
                                                <div class="mb-2">
                                                    <i class="bi {{ $iconClass }} text-{{ $accuracyClass }} fs-4"></i>
                                                </div>
                                                <h6 class="text-{{ $accuracyClass }} mb-1">Status</h6>
                                                <span class="badge bg-{{ $accuracyClass }} rounded-pill px-3">
                                                    {{ $statusText }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 rounded-4 bg-light text-center h-100">
                                                <div class="mb-2">
                                                    <i class="bi bi-bullseye text-primary fs-4"></i>
                                                </div>
                                                <h6 class="text-primary mb-1">Akurasi</h6>
                                                <span class="badge bg-primary rounded-pill px-3">
                                                    {{ 100 - number_format($mape, 2) }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- MAPE Interpretation -->
                        <div class="col-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-semibold mb-4">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Interpretasi MAPE
                                    </h6>
                                    
                                    <!-- Interpretation Levels -->
                                    <div class="d-flex flex-column gap-3">
                                        <!-- Sangat Baik -->
                                        <div class="interpretation-item">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    <span class="fw-semibold">Sangat Baik</span>
                                                </div>
                                                <span class="badge bg-success rounded-pill px-3">≤ 10%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: 10%"></div>
                                            </div>
                                        </div>
                    
                                        <!-- Baik -->
                                        <div class="interpretation-item">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-hand-thumbs-up-fill text-info"></i>
                                                    <span class="fw-semibold">Baik</span>
                                                </div>
                                                <span class="badge bg-info rounded-pill px-3">11-20%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-info" style="width: 20%"></div>
                                            </div>
                                        </div>
                    
                                        <!-- Cukup -->
                                        <div class="interpretation-item">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-exclamation-circle-fill text-warning"></i>
                                                    <span class="fw-semibold">Cukup</span>
                                                </div>
                                                <span class="badge bg-warning rounded-pill px-3">21-50%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                                            </div>
                                        </div>
                    
                                        <!-- Rendah -->
                                        <div class="interpretation-item">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                                    <span class="fw-semibold">Rendah</span>
                                                </div>
                                                <span class="badge bg-danger rounded-pill px-3">> 50%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-danger" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <style>
                    .progress.rounded-circle {
                        background: rgba(0,0,0,0.05);
                        transform: rotate(-90deg);
                    }
                    
                    .interpretation-item {
                        padding: 0.75rem;
                        border-radius: 0.75rem;
                        transition: all 0.3s ease;
                    }
                    
                    .interpretation-item:hover {
                        background-color: rgba(0,0,0,0.02);
                    }
                    
                    .card {
                        transition: all 0.3s ease;
                    }
                    
                    .card:hover {
                        transform: translateY(-2px);
                    }
                    </style>
                </div>
            </div>
        </div>
    </div>

    <!-- Visualization Card -->
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Visualisasi Prediksi</h5>
            <a href="{{ route('train.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-calculator me-2"></i>Prediksi Baru
            </a>
        </div>
        <div class="card-body">
            <h6>Perbandingan Data Aktual vs Prediksi DES</h6>
            <div id="chart" class="mb-4"></div>

            <div class="row g-4">
                <!-- Komponen DES Table -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-transparent border-0 py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-calculator-fill text-primary"></i>
                                    <h6 class="card-title mb-0 fw-semibold">Komponen DES</h6>
                                </div>
                                <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('prediksi.download', 'komponen-des') }}'">
                                    <i class="bi bi-download me-1"></i>Download PDF
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" id="komponen-des">
                                <table class="table table-hover mb-0 table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center px-4 py-3 border-0">
                                                <span class="text-muted fw-semibold">Bulan</span>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="badge bg-primary-subtle text-primary rounded-pill">Lt</span>
                                                    <span class="text-muted fw-semibold">Level</span>
                                                </div>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="badge bg-success-subtle text-success rounded-pill">Tt</span>
                                                    <span class="text-muted fw-semibold">Trend</span>
                                                </div>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="badge bg-info-subtle text-info rounded-pill">Ft</span>
                                                    <span class="text-muted fw-semibold">Forecast</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top">
                                        @foreach ($prediksiData as $data)
                                        <tr class="align-middle">
                                            <td class="text-center px-4">{{ $data['bulan'] }}</td>
                                            <td class="text-center px-4">
                                                <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded">
                                                    {{ number_format($data['level'], 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center px-4">
                                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded">
                                                    {{ number_format($data['trend'], 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center px-4">
                                                <span class="badge bg-info-subtle text-info px-2 py-1 rounded">
                                                    {{ number_format($data['prediksi_f'], 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Perhitungan Error Table -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-transparent border-0 py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clipboard-data-fill text-danger"></i>
                                    <h6 class="card-title mb-0 fw-semibold">Perhitungan Error</h6>
                                </div>
                                <button class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('prediksi.download', 'perhitungan-error') }}'">
                                    <i class="bi bi-download me-1"></i>Download PDF
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" id="perhitungan-error">
                                <table class="table table-hover mb-0 table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center px-4 py-3 border-0">
                                                <span class="text-muted fw-semibold">Bulan</span>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <span class="text-muted fw-semibold">Aktual</span>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <span class="text-muted fw-semibold">Prediksi</span>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <span class="text-muted fw-semibold">|Error|</span>
                                            </th>
                                            <th class="text-center px-4 py-3 border-0">
                                                <span class="text-muted fw-semibold">APE (%)</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top">
                                        @foreach ($prediksiData as $data)
                                            @if($data['tahun'] === '2023')
                                            <tr class="align-middle">
                                                <td class="text-center px-4">{{ $data['bulan'] }}</td>
                                                <td class="text-center px-4">
                                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded">
                                                        {{ $data['aktual_y'] }}
                                                    </span>
                                                </td>
                                                <td class="text-center px-4">
                                                    <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded">
                                                        {{ number_format($data['prediksi_f'], 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center px-4">
                                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded">
                                                        {{ number_format(abs($data['aktual_y'] - $data['prediksi_f']), 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center px-4">
                                                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded">
                                                        {{ $data['ap'] ? number_format($data['ap'], 2) . '%' : '-' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <style>
            .card {
                transition: transform 0.2s ease-in-out;
            }
            
            .card:hover {
                transform: translateY(-2px);
            }
            
            .table > :not(caption) > * > * {
                padding: 1rem 0.75rem;
            }
            
            .table-hover tbody tr:hover {
                background-color: rgba(0,0,0,.02) !important;
            }
            
            .badge {
                font-weight: 500;
                letter-spacing: 0.3px;
            }
            
            .bg-light {
                background-color: #f8f9fa !important;
            }
            
            .border-top {
                border-top: 1px solid #e9ecef !important;
            }
            </style>
        </div>
    </div>
</div>

@if(!empty($prediksiData))
<script>
    var options = {
        series: [{
            name: 'Data Aktual',
            type: 'scatter',
            data: [
                @foreach ($prediksiData as $data)
                    {{ isset($data['aktual_y']) ? $data['aktual_y'] : 'null' }},
                @endforeach
            ]
        }, {
            name: 'Hasil Prediksi DES',
            type: 'line',
            data: [
                @foreach ($prediksiData as $data)
                    {{ $data['prediksi_f'] }},
                @endforeach
            ]
        }],
        chart: {
            height: 500,
            type: 'line',
            zoom: {
                enabled: true,
                type: 'x',
                autoScaleYaxis: true
            },
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            },
            dropShadow: {
                enabled: true,
                top: 3,
                left: 2,
                blur: 4,
                opacity: 0.1
            }
        },
        markers: {
            size: [6, 0],
            strokeWidth: 2,
            hover: {
                size: 9
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: [0, 3],
            dashArray: [0, 0]
        },
        colors: ['#3b82f6', '#ef4444'],
        grid: {
            borderColor: '#f1f1f1',
            row: {
                colors: ['transparent', 'transparent'],
                opacity: 0.5
            },
            xaxis: {
                lines: {
                    show: true
                }
            }
        },
        xaxis: {
            categories: [
                @foreach ($prediksiData as $data)
                    '{{ $data['bulan'] }}',
                @endforeach
            ],
            title: {
                text: 'Periode',
                style: {
                    fontSize: '14px',
                    fontWeight: 600
                }
            },
            labels: {
                rotate: -45,
                style: {
                    fontSize: '12px'
                }
            },
            axisBorder: {
                show: true,
                color: '#78909c'
            },
            axisTicks: {
                show: true,
                color: '#78909c'
            }
        },
        yaxis: {
            title: {
                text: 'Jumlah Permintaan',
                style: {
                    fontSize: '14px',
                    fontWeight: 600
                }
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(0)
                },
                style: {
                    fontSize: '12px'
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            floating: false,
            offsetY: -25,
            offsetX: -5,
            markers: {
                width: 12,
                height: 12,
                strokeWidth: 0,
                radius: 12,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 0
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(value) {
                    return value.toFixed(2)
                }
            },
            marker: {
                show: true
            }
        },
        theme: {
            mode: 'light',
            palette: 'palette1'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endif
@endsection