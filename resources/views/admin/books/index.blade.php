@extends('layout.app')

@section('content')
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success my-3{{ session('success') }} </div>
@endif
    <div class="d-flex
                justify-content-between">
                <h3>Data Buku</h3>
                <a href="{{ route('admin.books.create') }}" class="btn
        btn-success"> Tambah Data Buku </a>
            </div>

            <table class="table table-bordered mt-3" id="data-buku">
                <thead>
                    <tr>
                        <th> #</th>
                        <th>Sampul bUku </th>
                        <th>judul</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
    </div>


    <div class="modal modal-blur fade" id="modal-blurred" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"
            style="width: calc(100% - 24px); max-width: 800px; margin: 12px auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4 text-center text-md-start">
                            <img src="" id="data-cover" class="img-fluid rounded shadow-sm"
                                style="width: 100%; max-width: 230px; height: 270px; object-fit: cover;" />
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="height: 50px">
                                <h3 class="text-primary" id="data-title"></h3>
                                <p class="badge badge-primary" id="data-category"></p>
                            </div>
                            <div>
                                <p>Harga <br> <span id="data-price" class="text-success"></span></p>
                                <p>Penerbit <br> <span id="data-publisher"></span></p>
                                <p>Tanggal rilis <br> <span id="data-release-date"></span></p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="height: 54px"></div>
                            <div>
                                <p>Penulis <br> <span id="data-writer"></span></p>
                                <p>Bahasa <br> <span id="data-language"></span></p>
                                <p>Jumlah Halaman <br> <span id="data-page-of-book"></span></p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <h6 class="text-secondary fw-bold">DESKRIPSI BUKU</h6>
                    <div id="data-description" class="border rounded p-3 bg-light"
                        style="height: 210px; overflow-y: auto; white-space: pre-line;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#data-buku').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'coverImg',
                        name: 'coverImg',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },

                    {
                        data: 'book_category_id',
                        name: 'bookCategory.nama_kategori'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    }
                ],
            });
            //proses memunculkan modal ketika btn detail di klik
            $("#data-buku").on('click', '.btn-detail', function() {
                const btn = $(this);
                //admbil data attribut data-title="" yang dikirimkan di datatable controller
                let title = btn.data('title');
                let category = btn.data('category');
                let price = btn.data('price');
                let publisher = btn.data('publisher');
                let writer = btn.data('write');
                let pageOfBook = btn.data('pageOfBook');
                let releaseDate = btn.data('release');
                let language = btn.data('language')
                let description = btn.data('description');

                $("#data-title").text(title);
                $("#data-category").text(category);
                $("#data-price").text('Rp ' + Number(price).toLocaleString('id-ID')); //rp
                $("#data-publisher").text(publisher);
                $("#data-writer").text(writer);
                $("#data-page-of-book").text(pageOfBook);
                $("#data-release-date").text(releaseDate);
                $("#data-language").text(language);
                $("#data-description").text(description || 'Deskripsi belum tersedia.');

                let cover = btn.data('cover');
                $("#data-cover").attr("src", cover);

            });
        });
    </script>
@endpush
