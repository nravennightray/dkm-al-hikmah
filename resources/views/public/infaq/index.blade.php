@extends('master.layout.app')

@section('title', 'Infaq & Sedekah - DKM Al Hikmah')

@section('content')

<div class="section-xl position-relative overflow-hidden"
     style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">
    
    <!-- Decorative Glow -->
    <div class="position-absolute top-0 start-0 translate-middle rounded-circle"
         style="width: 320px; height: 320px; background: rgba(255,255,255,0.14); filter: blur(70px);">
    </div>

    <div class="position-absolute bottom-0 end-0 translate-middle-y rounded-circle"
         style="width: 380px; height: 380px; background: rgba(125, 211, 252, 0.22); filter: blur(80px);">
    </div>

    <div class="container position-relative text-center pt-5">
        <div class="d-inline-flex align-items-center px-4 py-2 mb-4 rounded-pill"
             style="background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(10px);">
            <i class="bi bi-heart-fill me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">Dukung Kebaikan</span>
        </div>

        <h1 class="fw-bold text-white display-4">Infaq & Sedekah</h1>

        <p class="text-white mt-3 mb-0">
            "Harta tidak akan berkurang karena sedekah." (HR. Muslim)
        </p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">

            <!-- Left: Info & QRIS -->
            <div class="col-lg-6 text-center">
                <div class="p-4 bg-white shadow-sm border-radius h-100">
                    <div class="mb-4">
                        <span class="badge rounded-pill px-3 py-2 mb-3"
                              style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            QRIS Infaq
                        </span>

                        <h4 class="fw-bold mb-2">Scan QRIS Infaq</h4>

                        <p class="text-muted small mb-0">
                            Salurkan infaq dengan mudah melalui QRIS resmi DKM Al Hikmah.
                        </p>
                    </div>

                    {{-- Replace with your actual QRIS image --}}
                    <div class="p-3 border-radius mb-3"
                         style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%); border: 1px solid rgba(37, 99, 235, 0.12);">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=DKM-AL-HIKMAH"
                             alt="QRIS"
                             class="img-fluid"
                             style="max-width: 250px;">
                    </div>

                    <p class="small text-muted mb-0">
                        Mendukung semua e-wallet seperti GoPay, OVO, DANA, LinkAja, dan mobile banking.
                    </p>
                </div>
            </div>

            <!-- Right: Bank Accounts -->
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Transfer Bank</h2>

                <p class="text-muted mb-4">
                    Anda dapat menyalurkan donasi melalui transfer ke rekening resmi DKM Al Hikmah di bawah ini:
                </p>

                @foreach($accounts as $acc)
                    <div class="card border-0 border-radius mb-3 overflow-hidden"
                         style="background: #f8fbff; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);">
                        <div class="card-body d-flex justify-content-between align-items-center p-4">
                            <div>
                                <span class="badge rounded-pill mb-2 px-3 py-2"
                                      style="background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9); color: #ffffff;">
                                    {{ $acc->bank }}
                                </span>

                                <h3 class="fw-bold mb-1 letter-spacing-1" style="color: #0f172a;">
                                    {{ $acc->number }}
                                </h3>

                                <small class="text-muted">
                                    a.n {{ $acc->holder }}
                                </small>
                            </div>

                            <button class="btn btn-sm border-radius px-3"
                                    style="background: #ffffff; color: #2563eb; border: 1px solid rgba(37, 99, 235, 0.25); box-shadow: 0 8px 20px rgba(37, 99, 235, 0.12);">
                                <i class="far fa-copy me-1"></i> Salin
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="mt-5 p-4 border-radius small"
                     style="background: #eff6ff; border: 1px solid rgba(37, 99, 235, 0.18); color: #475569;">
                    <i class="fas fa-info-circle me-2" style="color: #2563eb;"></i>
                    Mohon sertakan kode unik atau melakukan konfirmasi ke Bendahara DKM setelah melakukan transfer untuk mempermudah pencatatan laporan keuangan.
                </div>
            </div>

        </div>
    </div>
</div>

@endsection