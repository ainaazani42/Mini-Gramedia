@extends('layout.app')
@section('content')
    <div class="container py-4">
        <h3>Pembayaran</h3>
        <div class="row mt-3">
            <div class="col-8">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="text-center">Scan QRCode</h3>
                        <p class="text-center text-secondary">Gunakan aplikasi e-wallet atau m-banking Anda untuk memindai
                            kode di bawah ini</p>
                        <div class="d-flex justify-content-center">
                            {{-- gambar qrcode --}}
                            {!! QrCode::size(250)->generate($package->id) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 px-2">
                <div class="card">
                    <form action="{{ route('subscription-packages.checkout', $package->id) }}"
                        method="POST"class="card-body">
                        <h4>Detail Pembelian</h4>
                        <div class="d-flex justify-content-between ps-2">
                            <p>Total Item</p>
                            <p class="text-secondary">1</p>
                        </div>
                        <h4>Subtotal</h4>
                        <div class="d-flex justify-content-between ps-2">
                            <p>Total Harga</p>
                            <p class="text-secondary">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between ps-2 text-danger">
                            <p>Total Diskon</p>
                            <p class="text-secondary">Rp{{ number_format($package->price * 0.2, 0, ',', '.') }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between ps-2">
                            <h4>Total Bayar</h4>
                             <h4 class="text-primary">
                                Rp{{ number_format($package->price - $package->price * 0.2, 0, ',', '.') }}</h4>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill mt-2 w-100">Bayar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
