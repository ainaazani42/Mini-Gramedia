<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageUser;
use App\Exports\SubscriptionPackageExport; // Pastikan menggunakan class export yang benar
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class SubscriptionPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model  = SubscriptionPackage::query();

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $editUrl = route('admin.paket-langganan.edit', $data->id);
                    $deleteUrl = route('admin.paket-langganan.destroy', $data->id);
                    $books =  route('admin.subscription-packages.books', $data->id);

                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btnEdit = '<a href="' . $editUrl . '" class="btn btn-warning btn-sm me-2">Edit</a>';
                    $btnDelete = '<form action="' . $deleteUrl . '" method="POST" class="d-inline">' . $csrf . $method . '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus paket langganan ini?\')">Hapus</button></form>';
                    $btnBooks = '<a href="' . $books . '" class="btn btn-info btn-sm">Buku</a>';

                    return $btnEdit . $btnDelete . $btnBooks;
                })->rawColumns(['action'])
                ->toJson();
        }
        return view('admin.subscription-package.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|string|max:50',
            'price' => 'required|integer|min:0',
        ]);

        SubscriptionPackage::create($validated);

        return redirect()->route('admin.paket-langganan.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        return view('admin.subscription-package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|string|max:50',
            'price' => 'required|integer|min:0',
        ]);

        $package->update($validated);

        return redirect()->route('admin.paket-langganan.index')->with('success', 'Paket langganan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = SubscriptionPackage::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.paket-langganan.index')->with('success', 'Paket langganan berhasil dihapus.');
    }

    public function checkoutPage(string $id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        return view('user.subscription-package.checkout', compact('package'));
    }

    public function checkout(Request $request, string $id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        SubscriptionPackageUser::create([
            'user_id' => Auth::id(),
            'subscription_package_id' => $package->id,
            'expired_date' => now()->addDays(30)->format('Y-m-d'),
        ]);

        return redirect()->route('home')->with('succes', 'Pembayaran berhasil. Terima kasih telah berlangganan paket!');
    }

    public function export()
    {
        return Excel::download(
            new SubscriptionPackageExport,
            'data_paket_langganan.xlsx'
        );
    }

    
}