@extends('layout.app')

@section('content')
    <div class="container py-4">
        <div class="row g-3">

            {{-- Bagian Profil --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="rounded-circle bg-light text-secondary border d-flex align-items-center justify-content-center fw-semibold mx-auto mb-2"
                                style="width: 55px; height: 55px; font-size: 22px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>

                            <h4>{{ $user->name }}</h4>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>

                        <hr style="margin-top: 15px; margin-bottom: 15px;">

                        <h3 class="text-primary">Profil Summary</h3>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Koleksi Buku</span>
                            <strong>{{ $bookCount }}</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Langganan</span>
                            <strong>{{ $subscriptionCount }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Transaksi --}}
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Transaksi</h5>

                    <div>
                        <label for="jenisTransaksi" class="form-label mb-1">
                            Jenis Transaksi
                        </label>

                        <select id="jenisTransaksi" class="form-select">
                            <option value="langganan">Paket Langganan</option>
                            <option value="buku">Buku</option>
                        </select>
                    </div>
                </div>

                {{-- Transaksi Paket Langganan --}}
                <div id="transaksiLangganan">

                    @forelse ($subscriptions as $subscription)
                        <div class="card shadow-sm mb-3">
                            <div class="card-body p-3">

                                {{-- Tanggal dan Status --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        {{ $subscription->created_at->format('d M Y, H:i') }}
                                    </small>

                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        Transaksi Sukses
                                    </span>
                                </div>

                                <hr style="margin-top: 15px; margin-bottom: 15px;">

                                {{-- Detail Transaksi --}}
                                <div class="row align-items-center">

                                    {{-- Nama Paket --}}
                                    <div class="col-md-4">
                                        <strong>
                                            {{ $subscription->subscriptionPackage->name }}
                                        </strong>
                                    </div>

                                    {{-- Masa Berlaku --}}
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-danger px-3 py-2 text-white">
                                            Berlaku s/d:
                                            {{ \Carbon\Carbon::parse($subscription->expired_date)->format('d M Y') }}
                                        </span>
                                    </div>

                                    {{-- Total Pembayaran --}}
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                        <small class="text-muted d-block">
                                            Total Pembayaran
                                        </small>

                                        <strong>
                                            Rp
                                           {{ number_format($subscription->subscriptionPackage->price - $subscription->subscriptionPackage->price * 0.2, 0, ',', '.') }}
                                        </strong>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm">
                            <div class="card-body text-center text-muted">
                                Belum ada transaksi paket langganan.
                            </div>
                        </div>
                    @endforelse

                </div>

                {{-- Transaksi Buku --}}
                <div id="transaksiBuku" style="display: none;">
                    <div class="card shadow-sm">
                        <div class="card-body text-center text-muted py-4">

                            <i class="fa-solid fa-book-open fs-1 mb-2"></i>

                            <p class="mb-0">
                                Riwayat pembelian buku belum ditampilkan.
                            </p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('jenisTransaksi').addEventListener('change', function() {
            const langganan = document.getElementById('transaksiLangganan');
            const buku = document.getElementById('transaksiBuku');

            if (this.value === 'langganan') {
                langganan.style.display = 'block';
                buku.style.display = 'none';
            } else {
                langganan.style.display = 'none';
                buku.style.display = 'block';
            }
        });
    </script>
@endsection
