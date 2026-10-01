@extends('layout.app')
@section('content')
    <div class="card mt-5 w-50 mx-auto">
        <div class="card-header">
            <h1>Edit Kategori Buku </h1>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.book-categories.update', $bookCategory->id) }}" method="POST">
                @csrf
                {{-- Overide method: mengambil method="post" menjadi put sesuai dengan http method yang ada di routw nya --}}
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    {{-- old('name', 'bookcategories->name') jika ada error validasi, tampilkan nilai sebelumnya pada inputan ini
                jika tidk ada, tampilkan nilai dari $bookCategory->name   --}}
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid
                   @enderror"
                        value="{{ old('name', $bookCategory->nama_kategori) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }} </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $bookCategory->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan </button>
            </form>
        </div>
    </div>
@endsection
