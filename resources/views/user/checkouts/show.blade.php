@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="card mt-5">
            <div class="card-body">
                <h2 class="text-center">{{ $checkout->order_code }}</h2>
                <p class="text-secondary text-center">{{ \Carbon\Carbon::parse($checkout->created_at)->format('d F Y') }}</p>

                <hr>

                @foreach ($checkout->checkoutBooks as $item )
                    <div class="d-flex-justify-content-between mt-2">
                        <p>{{ $item->book->title }}</p>
                        <p>Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between">
                    <h3>Total</h3>
                    <h3>Rp {{ number_format($checkout->total_price, 0, ',', '.') }}</h3>
                </div>
                @if (strtolower($checkout->status) == "pending")
               <button class="btn btn-primary" id="pay-button">Pay Now</button>
               <div id="payment-feedback" class="alert alert-warning mt-3 d-none" role="alert"></div>
               @else
               Payment successful
               @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ config('midtrans.snap_js_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const payButton = document.querySelector('#pay-button');
            const feedback = document.querySelector('#payment-feedback');

            if (!payButton) {
                return;
            }

            payButton.addEventListener('click', event => {
                event.preventDefault();

                if (!window.snap) {
                    console.error('Midtrans Snap gagal dimuat.');
                    feedback.className = 'alert alert-danger mt-3';
                    feedback.textContent = 'Pembayaran tidak dapat dibuka. Muat ulang halaman atau coba lagi nanti.';
                    return;
                }

                window.snap.pay(@json($snapToken), {
                    onSuccess: function() {
                        window.location.reload();
                    },
                    onPending: function() {
                        feedback.className = 'alert alert-warning mt-3';
                        feedback.textContent = 'Selesaikan pembayaran melalui metode yang dipilih.';
                    },
                    onError: function() {
                        feedback.className = 'alert alert-danger mt-3';
                        feedback.textContent = 'Pembayaran gagal diproses. Silakan coba lagi atau pilih metode pembayaran lain.';
                    },
                    onClose: function() {
                        feedback.className = 'alert alert-warning mt-3';
                        feedback.textContent = 'Jendela pembayaran ditutup sebelum pembayaran selesai.';
                    }
                });
            });
        });
    </script>
@endpush