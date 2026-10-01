@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Tambah Paket Langganan</h2>
            <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary mb-3">
                Tambah paket langganan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">


            <table class="table table-bordered bg-white w-100" id="subscription-packages-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>color</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>

            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#subscription-packages-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.subscriptions.index') }}",
                columns: [{
                    
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'description',
                        name: 'description',

                    },
                    {
                        data: 'color',
                        name: 'color',

                    },
                    {
                        data: 'price',
                        name: 'price',


                    },
                    {
                        data: 'action',

                    }
                ]
            })
        });
    </script>
@endpush
