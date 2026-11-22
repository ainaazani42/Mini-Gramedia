<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Book::with('bookCategory');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($row) {
                    return '<img src="' . asset($row->cover) . '" width="100"class="d-block mx-auto"/>';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp ' . number_format($row->price, 0, ',', '.');
                })
                ->addColumn('category', function ($row) {
                    return $row->bookCategory->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.books.edit', $row->id);
                    $deleteUrl = route('admin.books.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btnEdit = '<a href="' . $editUrl . '"
                                    class="btn btn-sm btn-primary me-2">Edit</a>';
                    $btnDelete = '<form action="' . $deleteUrl . '"method="POST"
                                class="d-inline">' . $csrf . $method . '<button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Apakah Anda yakin ingin menghapus buku ini?\')">
                                        Hapus
                                    </button>
                                </form>';
                    $btnDetail = '<button type="button" class="btn btn-sm btn-primary me-2" id="btn-detail"
                        data-cover="' . e(asset($row->cover)) . '"
                        data-title="' . e($row->title) . '"
                        data-category="' . e($row->bookCategory->name) . '"
                        data-price="' . e('Rp' . number_format($row->price, 0, ',', '.')) . '"
                        data-writer="' . e($row->writer) . '"
                        data-publisher="' . e($row->publisher) . '"
                        data-language="' . e($row->language) . '"
                        data-page-of-book="' . e($row->page_of_book) . '"
                        data-release-date="' . e(date('d M Y', strtotime($row->release_date))) . '"
                        data-description="' . e($row->description) . '"
                        >Detail</button>';
                    return $btnEdit . $btnDelete . $btnDetail;
                })->rawColumns(['action', 'coverImg'])
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
        $validatedData = $request->validate([
            'cover' => 'required|mimes:jpeg,png,jpg,webp,svg',
            'title' => 'required',
            'writer' => 'required',
            'publisher' => 'required',
            'price' => 'required|numeric',
            'language' => 'required',
            'description' => 'nullable',
            //exist:table,field = data harus udah ada di table book_categories field id
            'book_category_id' => 'required|exists:book_categories,id',
            'release_date' => 'required|date',
            'page_of_book' => 'required|numeric',
        ]);

        //kalo input file cover ada di filenya maka proses simpen ke file storage
        if ($request->file('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            if ($coverPath === false) {
                throw new \RuntimeException('Gagal menyimpan sampul buku.');
            }
            $validatedData['cover'] = Storage::url($coverPath);
        }

        Book::create($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Berhasil membuat data buku baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::where('id', $id)->with('subscriptionPackageBooks')->first();
    return view('user.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $bookCategories = BookCategory::all();
        return view('admin.books.edit', compact('book', 'bookCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg',
            'title' => 'required',
            'writer' => 'required',
            'publisher' => 'required',
            'price' => 'required|numeric',
            'language' => 'required',
            'description' => 'nullable',
            //exist:table,field = data harus udah ada di table book_categories field id
            'book_category_id' => 'required|exists:book_categories,id',
            'release_date' => 'required|date',
            'page_of_book' => 'required|numeric',
        ]);
        $oldImagePath = $book->cover
            ? str_replace('/storage/', '', $book->cover)
            : null;

        if ($request->hasFile('cover')) {
            $coverImage = $request->file('cover');
            $coverImagePath = $coverImage->store('covers', 'public');
            if ($coverImagePath === false) {
                throw new \RuntimeException('Gagal menyimpan sampul buku.');
            }
            $validatedData['cover'] = Storage::url($coverImagePath);
        }
        $book->update($validatedData);

        if (isset($coverImagePath) && $oldImagePath && $oldImagePath !== $coverImagePath) {
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Berhasil mengubah data buku!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover) {
            $oldImagePath = str_replace('/storage/', '', $book->cover);

            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Berhasil menghapus data buku!');
    }
     public function export()
    {
        return Excel::download(new BookExport, 'data_buku.xlsx');
    }
}
