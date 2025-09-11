@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Product All Information</h5>

                <div class="table-responsive w-100">
                    <table id="dataTable" class="table table-striped table-bordered w-100 min-w-25">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <x-slot:breadcrumb>
            <li class="breadcrumb-item"><a href="#">Home</a></li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/product/get-list`,
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.delete_btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/product/delete/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        table.ajax.reload();
                    },
                    error: function(error) {
                        console.log('Error: ', error);
                    }
                });
            });
        });
    </script>
@endpush
