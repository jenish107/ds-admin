@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Invoice List</h5>

                <div class="d-flex align-items-end justify-content-between mb-3">
                    <a href="" class="btn btn-success text-light">
                        Add New Invoice
                    </a>
                </div>

                <div class="table-responsive w-100">
                    <table id="familyTable" class="table table-striped table-bordered w-100 min-w-25">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Customer name</th>
                                <th>Customer email</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </x-layout>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            var table = $('#familyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/invoice/get-list`,
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: "customer_name",
                        name: "customer_name"
                    },
                    {
                        data: "customer_email",
                        name: "customer_email"
                    },
                    {
                        data: "user",
                        name: "user"
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
                    url: `/invoice/delete/${id}`,
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
