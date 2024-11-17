@extends('partials.main')

@section('title', 'Penjualan')

@section('main')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block card mb-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title border-bottom pb-2 mb-2">
                            <h4 class="mb-0">Data Penjualan Produk Pertanian UD Dison</h4>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('sales.index') }}">
                                    <i class="ph ph-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Penjualan Barang Pertanian UD Dison</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Penjualan</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Penjualan
                        </a>
                        <form action="{{ route('sales.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
                            @csrf
                            <label for="file-input" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-file-import me-1"></i> Import
                            </label>
                            <input type="file" name="file" id="file-input" accept=".csv, .xlsx" class="d-none" onchange="this.form.submit()">
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered" id="example" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->obat->nama_obat }}</td> <!-- Pastikan pakai 'nama_obat' -->
                                    <td>{{ $item->jumlah }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('sales.edit', $item->id) }}" class="btn btn-info btn-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('sales.destroy', $item->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
