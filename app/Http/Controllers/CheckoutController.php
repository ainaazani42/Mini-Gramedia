<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\CheckoutBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\DB;
use App\Service\Midtrans\CallbackService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selected_carts' => ['required', 'array', 'min:1'],
            'selected_carts.*' => ['required', 'exists:carts,id']
        ]);

        // whereIn : mencari data bertipe data array. mencari data id yang isinya sesuai sama selected_carts
        $cartItems = Cart::whereIn('id', $request->selected_carts)
            ->with(['book', 'subscriptionPackage'])
            ->where('user_id', Auth::id())
            ->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada item keranjang yang bisa di-checkout.');
        }

        // buat price yang akan disimpan ke checkoutBooks : satuan/paket langganan
        // harapan data =>  ['id' => 'price'] buat cari price itu punya item sama
        $prices = $cartItems->mapWithKeys(fn($row) => [
            $row->id => $row->subscription_package_id == null ? $row->book->price             : $row->subscriptionPackage->price
        ]);

        // jumlah total harga buku
        $totalPrice = $prices->sum();

        // mulai proses transaksi database
        DB::beginTransaction();
        try {
            // 1. bikin data checkout dulu
            $checkout = Checkout::create([
                'user_id' => Auth::id(),
                'payment_method' => 'Virtual Account',
                'total_price' => $totalPrice,
                'status' => 'pending',
                // hasil akhir : ORD-20261117-fghj
                'order_code' => 'ORD-' . now()->format('ymd') . '-' . strtolower(Str::random(4)),
                'total_book_price' => $totalPrice,
                'total_book' => $cartItems->count()
            ]);

            // 2. bikin data checkoutBooks sesuai dengan jumlah buku yang dipilih di keranjang
            foreach ($cartItems as $cart) {
                CheckoutBook::create([
                    'checkout_id' => $checkout->id,
                    'book_id' => $cart->book_id,

                    'total_book' => 1,
                    'subscription_package_id' => $cart->subscription_package_id,
                    // cari dari $prices yang diatas, cari harga sesuai id item yang di loop. isi prices
                    // [1 => 90000, 2 => 100000] dst. kalau di lopp ini id nya 2 maka ambil harga 100000
                    'price' => $prices[$cart->id]
                ]);
            }

            // 3. hapus item yang udah di checkout dari keranjangnya
            $cartIds = $cartItems->pluck('id'); //bikin array yang isinya id item di keranjang yang di checkoutin
            Cart::whereIn('id', $cartIds)->delete();

            // simpan/sahkan semua perubahan jika tidak ada error
            DB::commit();
        } catch (\Throwable $th) {
            // tarik semua perubahan jika ada error di try
            DB::rollBack();
            report($th);
            dd($th);
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silahkan coba lagi!');
        }

        // jika proses transaksi db sudah selesai, arahkan ke checkout show untuk proses snap token
        return redirect()->route('checkouts.show', $checkout->id);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
         
         $checkout = Checkout::findOrFail($id);
         $snapToken = $checkout->snap_token;
         if (is_null($snapToken)) {
             // If snap token is still NULL, generate snap token and save it to database

             $midtrans = new CreateSnapTokenService($checkout);
             $snapToken = $midtrans->getSnapToken();

             $checkout->snap_token = $snapToken;
             $checkout->save();
         }

         return view('user.checkouts.show', compact('checkout', 'snapToken'));
     }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function receive()
    {
        
    
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $checkout = $callback->getCheckout();

            if ($callback->isSuccess()) {
                Checkout::where('id', $checkout->id)->update([
                    'status' => 'paid',
                    'paid_date' => now(),
                    'payment_method' => $callback->getPaymentType(),
                ]);
            }

            if ($callback->isExpire()) {
                Checkout::where('id', $checkout->id)->update([
                    'status' => 'expired',
                ]);
            }

            if ($callback->isCancelled()) {
                Checkout::where('id', $checkout->id)->update([
                    'status' => 'cancelled',
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification successfully processed',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key not verified',
                ], 403);
        }
    }
    
    
}