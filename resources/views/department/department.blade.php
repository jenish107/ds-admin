@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Department All Information</h5>

                <div class="d-flex align-items-end justify-content-between mb-3">
                    <ol class="breadcrumb" style="background: none !important;">
                        <li class="breadcrumb-item"><a href="{{ route('showAllCompanies') }}"> <span
                                    class="text-secondary">Company | </span> {{ $company->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            department
                        </li>
                    </ol>
                    <a href="{{ route('showDepartmentForm', $company->id) }}" class="btn btn-success text-light">add new
                        department</a>
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
            <li class="breadcrumb-item active" aria-current="page">
                department
            </li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var companyId = {{ $company->id }};

            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/get-all-department/${companyId}`,
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
                    url: `/delete-department/${id}`,
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
