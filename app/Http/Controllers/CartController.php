<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\SubscriptionPackageUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();

        // mengambil data keranjang beserta relasi buku dan paket langganan
        $carts = Cart::with(['book', 'subscriptionPackage'])
            ->where('user_id', $user_id)
            ->get();

        // mengambil ID paket langganan aktif milik pengguna
        $activePackageIds = SubscriptionPackageUser::where('user_id', $user_id)
            ->whereDate('expired_date', '>', today())
            ->pluck('subscription_package_id');

        // mencari paket di keranjang yang belum dimiliki pengguna
        $packageUserNotBought = $carts
            ->whereNotNull('subscription_package_id')
            ->pluck('subscription_package_id')
            ->unique()
            ->diff($activePackageIds)
            ->values();

        // menambahkan attribute baru ke setiap data keranjang
        $carts->each(function ($cart) use ($packageUserNotBought) {

            // menentukan harga berdasarkan jenis item
            $cart->display_price = $cart->subscriptionPackage
                ? $cart->subscriptionPackage->price
                : $cart->book->price;

            // mengecek apakah paket belum dimiliki pengguna
            $cart->needs_package = $packageUserNotBought
                ->contains($cart->subscription_package_id);
        });

        // menghitung total harga seluruh item keranjang
        $totalPrice = $carts->sum('display_price');

        return view('user.carts.index', compact('carts', 'totalPrice'));
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
        // debugging: lihat data sebelum diproses
        // dd($request->all());

        $request->validate([
            // memastikan pilihan harga sudah dipilih
            'purchase_option' => 'required',
        ]);

        if ($request->action == 'add_to_cart') {

            // menentukan isi field subscription_package_id
            // 'none' berarti membeli satuan, sedangkan angka berarti ID paket
            $packageId = $request->purchase_option === 'none'
                ? null
                : (int) $request->purchase_option;

            // memperbarui data jika buku sudah ada di keranjang
            // atau membuat data baru jika belum ada
            Cart::updateOrCreate([
                'user_id' => Auth::user()->id,
                'book_id' => $request->book_id,
            ], [
                'subscription_package_id' => $packageId,
            ]);

            return redirect()->route('carts')
                ->with('success', 'Buku berhasil ditambahkan ke keranjang.');

        } elseif ($request->action == 'buy_now') {

            // untuk sementara arahkan ke halaman keranjang
            return redirect()->route('carts')
                ->with('success', 'Buku berhasil ditambahkan ke keranjang.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('carts')
            ->with('success', 'Buku berhasil dihapus dari keranjang!');
    }
}