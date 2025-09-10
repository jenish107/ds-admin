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

                <div class="d-flex align-items-end justify-content-between mb-3">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: none !important;">
                            <li class="breadcrumb-item"><a href="{{ route('showAllCompanies') }}"> <span
                                        class="text-secondary">Company |</span>
                                    {{ $department->company->name }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('showAllDepartment', $department->company->id) }}"> <span
                                        class="text-secondary">Department |</span>
                                    {{ $department->name }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                employ
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('showEmployForm', $department->id) }}" class="btn btn-success text-light">add new
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
                <a href="{{ route('showAllDepartment', $department->company->id) }}">department</a>
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
            var departmentId = {{ $department->id }};

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
