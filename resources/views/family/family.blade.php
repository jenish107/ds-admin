@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Family All Information</h5>

                <div class="d-flex align-items-end justify-content-between mb-3">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: none !important;">
                            <li class="breadcrumb-item"><a href="{{ route('showAllCompanies') }}"> <span
                                        class="text-secondary">Company |</span>
                                    {{ $employ->department->company->name }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('showAllDepartment', $employ->department->company->id) }}"> <span
                                        class="text-secondary">Department |</span>
                                    {{ $employ->department->name }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('showAllEmploy', $employ->department->id) }}"><span
                                        class="text-secondary">Employ
                                        |</span> {{ $employ->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span>Family</span>
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('showFamilyForm', $employ->id) }}" class="btn btn-success text-light">
                        Add New Family
                    </a>
                </div>

                <div class="table-responsive w-100">
                    <table id="familyTable" class="table table-striped table-bordered w-100 min-w-25">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>First name</th>
                                <th>Last name</th>
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
            <li class="breadcrumb-item">
                <a href="{{ route('showAllDepartment', $employ->department->company->id) }}">Department</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('showAllEmploy', $employ->department->id) }}">Employ</a>
            </li>
            <li class="breadcrumb-item active">
                <span>Family</span>
            </li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var employId = {{ $employ->id }};

            var table = $('#familyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/get-all-family/${employId}`,
                    type: 'GET'
                },
                lengthMenu: [2, 4, 10, 20, 30],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
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
                    url: `/delete-family/${id}`,
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
