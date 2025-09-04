@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush
@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Family All Information</h5>

                <div class="input-group d-flex justify-content-between my-3">
                    <div>
                        <select name="rowNumber" id="rowNumber">
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>

                    <div class="d-flex">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="search" name="search" id="search" placeholder="search here"
                                class="form-control" />
                            <label hidden class="form-label" for="search">Search</label>
                        </div>
                        <button type="button" class="btn btn-primary" data-mdb-ripple-init>
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-end justify-content-end mb-3">
                    <a href="{{ route('showFamilyForm', $employId) }}" class="btn btn-success text-light">add new
                        employ</a>
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

                <div class="d-flex justify-content-center">
                    <nav>
                        <ul class="pagination" id="pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <x-slot:breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('showAllCompanies') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('showAllDepartment', $companyId) }}">department</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('showAllEmploy', $departmentId) }}">employ</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <span>family</span>
            </li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        var employId = {{ $employId }};
        let rowNumber = 2;
        let name = undefined;

        function addRow(data) {
            $('#table-body').empty();
            data.map(family => {
                var currRow = $(`<tr id='table-row-${family.id}'></tr>`);
                currRow.append(`<td>${family?.id}</td>`);
                currRow.append(`<td>${family?.name}</td>`);
                currRow.append(`<td>${family?.email}</td>`);
                currRow.append(`
                        <td> 
                            <a href="/show-update-family-form/${family.id}/${employId}">
                                <button
                                type="button"
                                data-id='${family?.id}'
                                class="btn btn-success btn-sm text-white edit_btn"
                                >
                                    Edit
                                </button>
                            </a>
                            
                            <button
                            type="button"
                            data-id='${family?.id}'
                            class="btn btn-danger btn-sm text-white delete_btn"
                            >
                                delete
                            </button>
                        </td>
                        `);

                $('#table-body').append(currRow);
            });
        }

        function loadAllData($url = `/get-all-family/${employId}/2`) {
            if (name) {
                $url = `/get-all-family/${employId}/${rowNumber}/${name}`;
            }
            $.ajax({
                url: $url,
                type: 'GET',
                contentType: 'application/json',
                success: function(response) {
                    addRow(response['data']);
                    $('#pagination').empty();

                    $('#pagination').append(`
                                    <li class="page-item" id="prev_page_item">
                                        <a href="#" class="page-link" id="prev_page">Previous</a>
                                    </li>`);
                    $('#pagination').append(
                        `<li class="p-2 pb-1 border border-light-subtle" id="page-number">${response.current_page}</li>`
                    );
                    $('#pagination').append(`
                                    <li class="page-item" id="next_page_item">
                                        <a href="#" class="page-link" id="next_page">Next</a>
                                    </li>`);

                    if (response.prev_page_url) {
                        $('#prev_page').data('url', response.prev_page_url)
                    } else {
                        $('#prev_page_item').addClass('disabled')
                    }

                    if (response.next_page_url) {
                        $('#next_page').data('url', response.next_page_url)
                    } else {
                        $('#next_page_item').addClass('disabled')
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error :' + xhr.responseText);
                }
            })
        }

        $(document).ready(function() {
            loadAllData();

            $("#rowNumber").change(function() {
                rowNumber = $(this).val()
                loadAllData(`/get-all-family/${employId}/${rowNumber}`)
            })

            $(document).on('click', '#pagination a', function() {
                let url = $(this).data('url');
                if (url) {
                    loadAllData(url);
                }
            });

            $(document).on('click', '.delete_btn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/delete-family/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(`#table-row-${id}`).remove();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error :', xhr.responseText);
                    }
                })
            });

            //search
            $('#search').keyup(function() {
                name = $(this).val();

                loadAllData();
            })
        });
    </script>
@endpush
