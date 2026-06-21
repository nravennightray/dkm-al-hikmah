@extends('master.layout.app')

@section('title', ucwords(str_replace('-', ' ', $type)) . ' - DKM Al Hikmah')

@section('content')

<div class="section-xl" style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white">{{ ucwords(str_replace('-', ' ', $type)) }}</h1>
        <p class="text-white-50">Transparansi dana umat Masjid Al Hikmah</p>
    </div>
</div>

<div class="section">
    <div class="container">
        <!-- Summary Cards -->
        <div class="row g-4 mb-5 text-center">
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm border-radius border-start border-success border-4">
                    <small class="text-muted uppercase fw-bold">Total Masuk</small>
                    <h3 class="text-success mb-0">Rp 7.500.000</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm border-radius border-start border-danger border-4">
                    <small class="text-muted uppercase fw-bold">Total Keluar</small>
                    <h3 class="text-danger mb-0">Rp 500.000</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-success text-white shadow-sm border-radius">
                    <small class="opacity-75 uppercase fw-bold">Saldo Akhir</small>
                    <h3 class="mb-0">Rp 7.000.000</h3>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm border-radius overflow-hidden">
            <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-normal italic">Rincian Transaksi - Mei 2026</h5>
                <button class="btn btn-sm btn-outline-success"><i class="fas fa-download me-1"></i> PDF</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-end">Masuk (Debit)</th>
                            <th class="text-end">Keluar (Kredit)</th>
                            <th class="text-end pe-4">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $row)
                        <tr>
                            <td class="ps-4">{{ $row->date }}</td>
                            <td>{{ $row->desc }}</td>
                            <td class="text-end text-success">{{ $row->in }}</td>
                            <td class="text-end text-danger">{{ $row->out }}</td>
                            <td class="text-end fw-bold pe-4">{{ $row->balance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection