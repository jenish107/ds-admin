@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Users All Information</h5>

                <div class="input-group d-flex justify-content-end my-3">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="search" name="search" id="search" placeholder="search hear" class="form-control" />
                        <label hidden class="form-label" for="search">Search</label>
                    </div>
                    <button type="button" class="btn btn-primary" data-mdb-ripple-init>
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="d-flex align-items-end justify-content-end mb-3">
                    <a href="{{ route('showCompaniesForm') }}" class="btn btn-success text-light">add new
                        company</a>
                </div>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-layout>
@endsection

@push('scripts')
    <script>
        function addRow(data) {
            $('#table-body').empty();
            data.map(company => {
                var currRow = $(`<tr id='table-row-${company.id}'></tr>`);
                currRow.append(`<td>${company?.id}</td>`);
                currRow.append(`<td>${company?.name}</td>`);
                currRow.append(`<td>${company?.email}</td>`);
                currRow.append(`
                        <td> 
                            <a href="department-data/${company.id}">
                                 <i class="mdi mdi-account-multiple btn btn-info btn-sm"></i>
                           </a>

                            <a href="show-update-companies-form/${company.id}">
                                <button
                                type="button"
                                data-id='${company?.id}'
                                class="btn btn-success btn-sm text-white edit_btn"
                                >
                                    Edit
                                </button>
                            </a>
                            
                            <button
                            type="button"
                            data-id='${company?.id}'
                            class="btn btn-danger btn-sm text-white delete_btn"
                            >
                                delete
                            </button>
                        </td>
                        `);

                $('#table-body').append(currRow);
            });
        }

        function loadAllData() {
            $.ajax({
                url: '/get-all-companies',
                type: 'GET',
                contentType: 'application/json',
                success: function(response) {
                    addRow(response)
                },
                error: function(xhr, status, error) {
                    alert('Error :' + xhr.responseText);
                }
            })
        }
        $(document).ready(function() {
            loadAllData();

            $(document).on('click', '.delete_btn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/delete-companies/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log("user is deleted");
                        $(`#table-row-${id}`).remove();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error :', xhr.responseText);
                    }
                })
            });

            //search
            $('#search').keyup(function() {
                var name = $(this).val();

                if (name == "") {
                    loadAllData();
                } else {
                    $.ajax({
                        url: `/search-companies/${name}`,
                        type: 'GET',
                        success: function(response) {
                            console.log('response--', response)
                            addRow(response)
                        },
                        error: function(xhr, status, error) {
                            console.log('Error in search', xhr.responseText)
                        }
                    })
                }
            })
        });
    </script>
@endpush
