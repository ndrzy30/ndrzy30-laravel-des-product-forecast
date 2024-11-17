@extends('partials.main')
@section('title', 'Edit Obat')
@section('main')
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block card mb-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title border-bottom pb-2 mb-2">
                                <h4 class="mb-0">Edit Data Produk</h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}"><i class="ph ph-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('medicine.index') }}">Data Produk</a></li>
                                <li class="breadcrumb-item">Edit Produk</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="text-end">
                            <a href="{{ route('medicine.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('medicine.update', $data->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Kode Produk</label>
                                <input type="text"
                                       class="form-control @error('kode_obat') is-invalid @enderror"
                                       name="kode_obat"
                                       value="{{ old('kode_obat', $data->kode_obat) }}"
                                       required>
                                @error('kode_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Nama Obat</label>
                                <input type="text"
                                       class="form-control @error('nama_obat') is-invalid @enderror"
                                       name="nama_obat"
                                       value="{{ old('nama_obat', $data->nama_obat) }}"
                                       required>
                                @error('nama_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text"
                                       class="form-control @error('kategori') is-invalid @enderror"
                                       name="kategori"
                                       value="{{ old('kategori', $data->kategori) }}"
                                       required>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Satuan</label>
                                <input type="text"
                                       class="form-control @error('satuan') is-invalid @enderror"
                                       name="satuan"
                                       value="{{ old('satuan', $data->satuan) }}"
                                       required>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="form-group mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number"
                                       class="form-control @error('stok') is-invalid @enderror"
                                       name="stok"
                                       value="{{ old('stok', $data->stok) }}"
                                       required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('medicine.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
