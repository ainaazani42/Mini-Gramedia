@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Paket Langganan</h2>
                <div class="d-flex gap-2">
                <a href="{{ route('admin.paket-langganan.create') }}" class="btn btn-primary">Tambah Paket</a>
              <a href="{{ route('admin.paket-langganan.export') }}" class="btn btn-success">
                 Export Excel
                 </a>
            </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="table-paket" class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Warna</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#table-paket').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.paket-langganan.index') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'color',
                name: 'color'
            }, {
                data: 'price',
                name: 'price'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        });
    </script>
@endpush
