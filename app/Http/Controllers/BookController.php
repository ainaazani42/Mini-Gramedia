<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Book::query();

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($row) {
                    //asset: mengambil file yang ada di folder public
                    return '<img src="' . asset($row->cover) . '" width="100"
                class="d-block mx-auto" />';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp ' . number_format($row->price, 0, ',', ',');
                })
                ->editColumn('book_category_id', function ($row) {
                    return $row->bookCategory->nama_kategori;
                })
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('admin.books.edit', $row->id) . '" class="btn btn-primary">Edit</a>';
                    $btnDelete = '<form method="POST" action="' . route('admin.books.destroy', $row->id) . '">' . csrf_field() .
                        method_field('DELETE') . '<button type="submit" class="btn btn-danger">Delete</button></form>';

                    $btnDetail = '<button type="button" class="btn btn-primary btn-detail" data-bs-toggle="modal" data-bs-target="#modal-blurred"
                 data-cover="' . asset($row->cover) . '"
                 data-title="' . $row->title . '"
                 data-category="' . $row->bookCategory->nama_kategori . '"
                 data-price="' . $row->price . '"
                 data-write="' . $row->writer . '"
                 data-publisher="' . $row->publisher . '"
                 data-language="' . $row->language . '"
                 data-page-of-book="' . $row->page_of_book . '"
                 data-release="' . date('d M Y', strtotime($row->release_date)) . '"
                 data-description="'. e(strip_tags($row->description ?? '')) .'" 
                 >Detail</button>';
                    return '<div class="d-flex flex-column align-items-center gap-1">' .
                        $btnEdit . $btnDelete . $btnDetail . '</div>';
                })
                ->rawColumns(['action', 'coverImg'])
                ->toJson();
        }
        return view('admin.books.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookCategories = BookCategory::all();

        return view('admin.books.create', compact('bookCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validateData = $request->validate([
            'cover' => ['required', 'mimes:jpg,jpeg,png,svg,webp'],
            'title' => ['required'],
            'writer' => ['required'],
            'publisher' => ['required'],
            'price' => ['required', 'numeric'],
            'language' => ['required'],
            'description' => ['nullable'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
            'page_of_book' => ['required', 'numeric'],
            'release_date' => ['required', 'date']
        ]);

        if ($request->file('cover')) {
            $cover = $request->file('cover');
            $nameFile = time() . '.' . $cover->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('covers', $cover, $nameFile);
            $validateData['cover'] = Storage::url('covers/' . $nameFile);
        }

        Book::create($validateData);

        return redirect()->route('admin.books.index')->with('success', 'berhasil membuat data buku baru!');
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
}
