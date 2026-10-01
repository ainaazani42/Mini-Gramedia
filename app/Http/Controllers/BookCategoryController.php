<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = BookCategory::query();
            //request->ajax() kola ada permintaan dari ajax js, permintaan proses databels dipanggil memlalui ajax js
            return DataTables::eloquent($model)
                //memberikan nomor urut data 1-2-dst
                ->addIndexColumn()
                //menambahkan mengubah data asli yang ada di database
                //add colum di gunakan ketika kita butuh ouput nya ada styling nya
                ->addColumn('action', function ($data) {
                    // Pastikan menggunakan nama route yang benar sesuai di web.php
                    $editUrl = route('admin.book-categories.edit', $data->id);
                    $deleteUrl = route('admin.book-categories.destroy', $data->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $btnEdit = '<a href="' . $editUrl . '" class="btn btn-sm btn-outline-warning">Edit</a>';

                    $btnDelete = '<form action="' . $deleteUrl . '" method="POST" class="d-inline">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                    <i class="fa-solid fa-trash me-1"></i> Hapus
                                </button>
                              </form>';

                    return $btnEdit . $btnDelete;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $bookCategorys = BookCategory::all();

        return view('admin.book-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        BookCategory::create([
            'nama_kategori' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil ditambahkan.');
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
        $bookCategory = BookCategory::findOrFail($id);
        $category = $bookCategory;
        return view('admin.book-categories.edit', compact('bookCategory', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $bookCategory->update([
            'nama_kategori' => $validateData['name'],
            'description' => $validateData['description'] ?? null,
        ]);
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku telah berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);
        $bookCategory->delete();

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku telah berhasil dihapus.');
    }
}
