@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush
@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Department All Information</h5>

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
                            <input type="search" name="search" id="search" placeholder="search hear"
                                class="form-control" />
                            <label hidden class="form-label" for="search">Search</label>
                        </div>
                        <button type="button" class="btn btn-primary" data-mdb-ripple-init>
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-end justify-content-end mb-3">
                    <a href="{{ route('showDepartmentForm', $companyId) }}" class="btn btn-success text-light">add new
                        department</a>
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
            <li class="breadcrumb-item active" aria-current="page">
                department
            </li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script>
        var companyId = {{ $companyId }};
        let rowNumber = 2;
        let name = undefined;

        function addRow(data) {
            $('#table-body').empty();
            data.map(department => {
                var currRow = $(`<tr id='table-row-${department.id}'></tr>`);
                currRow.append(`<td>${department?.id}</td>`);
                currRow.append(`<td>${department?.name}</td>`);
                currRow.append(`<td>${department?.email}</td>`);
                currRow.append(`
                        <td> 
                            <a href="/employ-data/${department.id}">
                                 <i class="mdi mdi-account-multiple btn btn-info btn-sm"></i>
                           </a>

                            <a href="/show-update-department-form/${department.id}/${companyId}">
                                <button
                                type="button"
                                data-id='${department?.id}'
                                class="btn btn-success btn-sm text-white edit_btn"
                                >
                                    Edit
                                </button>
                            </a>
                            
                            <button
                            type="button"
                            data-id='${department?.id}'
                            class="btn btn-danger btn-sm text-white delete_btn"
                            >
                                delete
                            </button>
                        </td>
                        `);

                $('#table-body').append(currRow);
            });
        }

        function loadAllData($url = `/get-all-department/${companyId}/2`) {
            if (name) {
                $url = `/get-all-department/${companyId}/${rowNumber}/${name}`;
                console.log('name  ---', $url)
            }
            $.ajax({
                url: $url,
                type: 'GET',
                contentType: 'application/json',
                success: function(response) {
                    console.log('response --', response);
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
                let rowNumber = $(this).val()
                loadAllData(`/get-all-department/${companyId}/${rowNumber}`)
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
                    url: `/delete-department/${id}`,
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
