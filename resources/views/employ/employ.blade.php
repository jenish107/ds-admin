@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Employ All Information</h5>

                <div class="d-flex align-items-end justify-content-end mb-3">
                    <a href="{{ route('showEmployForm', $departmentId) }}" class="btn btn-success text-light">add new
                        employ</a>
                </div>

                <div class="table-responsive w-100">
                    <table id="dataTable" class="table table-striped table-bordered w-100 min-w-25">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <x-slot:breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('showAllCompanies') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('showAllDepartment', $companyId) }}">department</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                employ
            </li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var departmentId = {{ $departmentId }};

            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/get-all-employ/${departmentId}`,
                    type: 'GET'
                },
                lengthMenu: [2, 4, 10, 20, 30],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <a href="/family-data/${data.id}">
                                    <i class="mdi mdi-account-multiple btn btn-info btn-sm"></i>
                                </a>

                                <a href="/show-update-employ-form/${data.id}/${departmentId}">
                                    <button type="button" class="btn btn-success btn-sm text-white">Edit</button>
                                </a>

                                <button type="button" data-id="${data.id}" class="btn btn-danger btn-sm text-white delete_btn">Delete</button>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.delete_btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/delete-employ/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
