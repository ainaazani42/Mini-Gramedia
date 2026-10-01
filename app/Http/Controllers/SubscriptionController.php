<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = SubscriptionPackage::query();

            return DataTables::eloquent($model)
                ->addIndexColumn()

                ->addColumn('description', function ($data) {
                    return filled(trim($data->description ?? '')) ?
                        $data->description : 'PAKET LENGKAP';
                })

                ->addColumn('color', function ($data) {
                    return '<span style="display:inline-block; width:20px; height:20px; background-color:' .
                        $data->color . '; border-radius:4px;"></span> ' . $data->color;
                })

                ->addColumn('price', function ($data) {
                    return 'Rp ' . number_format($data->price, 0, ',', '.');
                })

                ->addColumn('action', function ($data) {
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '<a href="' . route('admin.subscriptions.edit', $data->id) . '"
                            class="btn btn-warning btn-sm">Edit</a>
                            <form action="' . route('admin.subscriptions.destroy', $data->id) . '"
                                 method="POST" class="d-inline">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm(\'Apakah Anda yakin ingin menghapus paket ini?\')">
                                    Hapus
                                </button>
                            </form>';
                })

                ->rawColumns(['color', 'action'])
                ->toJson();
        }
        return view('admin.subscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
        ]);
        $validated['description'] = filled(trim($validated['description'] ?? ''))
            ? trim($validated['description'])
            : 'PAKET LENGKAP';

        SubscriptionPackage::create($validated);
        return redirect()->route('admin.subscriptions.index')->with('success', 'Paket langganan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subscription = SubscriptionPackage::findOrFail($id);
        return view('admin.subscriptions.edit', ['subscriptionPackage' => $subscription]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subscription = SubscriptionPackage::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
        ]);
        $validated['description'] = filled(trim($validated['description'] ?? ''))
            ? trim($validated['description'])
            : 'PAKET LENGKAP';
        $subscription->update($validated);
        return redirect()->route('admin.subscriptions.index')->with('success', 'Paket langganan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscription = SubscriptionPackage::findOrFail($id);
        $subscription->delete();
        return redirect()->route('admin.subscriptions.index')->with('success', 'Paket langganan berhasil dihapus');
    }
}
