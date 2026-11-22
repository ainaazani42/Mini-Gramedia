<?php

namespace App\Http\Controllers;
use App\Exports\BookCategoriesExport;
use Illuminate\Http\Request;
use App\Models\BookCategory;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model  = BookCategory::query();

            return DataTables::eloquent($model)
                //menambahkan no urut data1-2
                ->addIndexColumn()
                //menambahkan data selain yang di database
                ->addColumn('action', function ($data) {
                    $editUrl = route('admin.book-categories.edit', $data->id);
                    $deleteUrl = route('admin.book-categories.destroy', $data->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btnEdit = '<a href="' . $editUrl . '"
                                    class="btn btn-warning btn-sm me-2">Edit</a>';
                    $btnDelete = '<form action="' . $deleteUrl . '"method="POST"
                                class="d-inline">' . $csrf . $method . '<button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Apakah Anda yakin ingin menghapus kategori ini?\')">
                                        Hapus
                                    </button>
                                </form>';
                    return $btnEdit . $btnDelete;
                })->rawColumns(['action'])
                ->toJson();
        }
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        BookCategory::create(['name' => $validatedData['name']]);

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
        return view('admin.book-categories.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bookCategory->update(['name' => $validated['name']]);
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);
        $bookCategory->delete();

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil dihapus');
    }
    public function export()
    {
        return Excel::download(new BookCategoriesExport, 'book_categories.xlsx');
    }
}
