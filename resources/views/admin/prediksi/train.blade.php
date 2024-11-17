@extends('partials.main')
@section('title', 'Lakukan Prediksi DES')

@section('main')
<div class="pc-content">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-2">Prediksi Produk Pertanian UD Dison</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ph ph-house"></i></a></li>
                    <li class="breadcrumb-item">Prediksi</li>
                    <li class="breadcrumb-item active">Lakukan Prediksi Metode Double Exponential Smoothing (DES)</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Title -->
    <h5 class="mb-4">Form Prediksi Metode Double Exponential Smoothing (DES)</h5>

    <form action="{{ route('predict.store') }}" method="POST" id="predictionForm">
        @csrf
        <div class="row g-4">
            <!-- Left Column - Drug Selection -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <h6 class="card-title fw-bold mb-3">
                                <i class="fas fa-pills text-primary me-2"></i>Pilih Barang
                            </h6>
                            <select name="obat_id" class="form-select custom-select @error('obat_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($drugs as $drug)
                                    <option value="{{ $drug->id }}">{{ $drug->nama_obat }}</option>
                                @endforeach
                            </select>
                            @error('obat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Parameters -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body p-4">
                        <h6 class="card-title fw-bold mb-3">
                            <i class="fas fa-sliders-h text-primary me-2"></i>Mode Parameter
                        </h6>
                        <div class="parameter-options rounded-4 p-4 bg-light">
                            <!-- Manual Mode -->
                            <div class="parameter-option mb-4">
                                <div class="form-check custom-radio">
                                    <input class="form-check-input" type="radio" name="parameter_mode"
                                           id="mode_manual" value="manual" checked>
                                    <label class="form-check-label fw-semibold" for="mode_manual">
                                        Parameter Manual
                                        <span class="text-muted ms-2 fw-normal">
                                            (Alpha <i>α</i> dan Beta <i>β</i>)
                                        </span>
                                    </label>
                                </div>

                                <!-- Manual Parameters -->
                                <div id="manual_params" class="mt-3 ps-4">
                                    <div class="parameter-inputs p-4 rounded-3 border border-2">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Alpha (α)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white">α</span>
                                                    <input type="number" class="form-control" name="alpha"
                                                           id="alpha" value="0.98" step="0.01" min="0" max="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Beta (β)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white">β</span>
                                                    <input type="number" class="form-control" name="beta"
                                                           id="beta" value="0.02" step="0.01" min="0" max="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-info mt-3 mb-0 py-2 small">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Jumlah Alpha (α) + Beta (β) harus = 1
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Auto Mode -->
                            <div class="parameter-option">
                                <div class="form-check custom-radio">
                                    <input class="form-check-input" type="radio" name="parameter_mode"
                                           id="mode_auto" value="auto">
                                    <label class="form-check-label fw-semibold" for="mode_auto">
                                        Parameter Otomatis
                                        <span class="badge bg-success ms-2">Optimal</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center py-3 submit-btn">
                    <i class="fas fa-calculator me-2"></i>
                    Prediksi dengan Metode DES
                </button>
            </div>
        </div>
    </form>

    <style>
    /* Card Styling */
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.1)!important;
    }

    /* Select Styling */
    .custom-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.2s;
    }
    .custom-select:focus {
        border-color: #4099ff;
        box-shadow: 0 0 0 0.2rem rgba(64,153,255,.25);
    }

    /* Radio Button Styling */
    .custom-radio .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.2em;
    }
    .custom-radio .form-check-input:checked {
        background-color: #4099ff;
        border-color: #4099ff;
    }

    /* Parameter Inputs */
    .parameter-inputs {
        background-color: white;
        border-color: #e9ecef !important;
    }
    .input-group-text {
        border: 2px solid #e9ecef;
        border-right: none;
    }
    .input-group .form-control {
        border: 2px solid #e9ecef;
        border-left: none;
    }
    .input-group .form-control:focus {
        border-color: #4099ff;
        box-shadow: none;
    }

    /* Submit Button */
    .submit-btn {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(64,153,255,0.3);
    }

    /* Alerts */
    .alert-info {
        background-color: rgba(64,153,255,0.1);
        border: none;
        color: #4099ff;
    }
    </style>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modeManual = document.getElementById('mode_manual');
        const modeAuto = document.getElementById('mode_auto');
        const manualParams = document.getElementById('manual_params');
        const alphaInput = document.getElementById('alpha');
        const betaInput = document.getElementById('beta');

        function toggleManualParams() {
            if (modeManual.checked) {
                manualParams.style.display = 'block';
                alphaInput.required = true;
                betaInput.required = true;
            } else {
                manualParams.style.display = 'none';
                alphaInput.required = false;
                betaInput.required = false;
            }
        }

        alphaInput.addEventListener('input', function() {
            const alphaValue = parseFloat(this.value);
            if (!isNaN(alphaValue) && alphaValue >= 0 && alphaValue <= 1) {
                betaInput.value = (1 - alphaValue).toFixed(2);
            }
        });

        betaInput.addEventListener('input', function() {
            const betaValue = parseFloat(this.value);
            if (!isNaN(betaValue) && betaValue >= 0 && betaValue <= 1) {
                alphaInput.value = (1 - betaValue).toFixed(2);
            }
        });

        // Form validation
        document.getElementById('predictionForm').addEventListener('submit', function(e) {
            if (modeManual.checked) {
                const alpha = parseFloat(alphaInput.value);
                const beta = parseFloat(betaInput.value);
                const sum = Math.round((alpha + beta) * 100) / 100;

                if (sum !== 1) {
                    e.preventDefault();
                    alert('Jumlah Alpha dan Beta harus sama dengan 1');
                }
            }
        });

        modeManual.addEventListener('change', toggleManualParams);
        modeAuto.addEventListener('change', toggleManualParams);

        // Initial state
        toggleManualParams();
    });
</script>

<style>
    .form-select,
    .form-control {
        border-radius: 8px;
        padding: 0.625rem 1rem;
    }
    .card {
        border-radius: 12px;
    }
    .btn-primary {
        border-radius: 8px;
        height: 48px;
    }
    .rounded-3 {
        border-radius: 12px !important;
    }
</style>
@endpush
@endsection
