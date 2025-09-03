@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Users All Information</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact No</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Zipcode</th>
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
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!-- this page js -->
    <script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $.ajax({
                url: '/get-all-user',
                type: 'GET',
                contentType: 'application/json',
                success: function(response) {
                    response.map(user => {
                        var currRow = $(`<tr></tr>`);

                        currRow.append(`<td>${user?.id}</td>`);
                        currRow.append(`<td>${user?.first_name}</td>`);
                        currRow.append(`<td>${user?.last_name}</td>`);
                        currRow.append(`<td>${user?.number}</td>`);
                        currRow.append(`<td>${user?.country?.name}</td>`);
                        currRow.append(`<td>${user?.state?.name}</td>`);
                        currRow.append(`<td>${user?.city?.name}</td>`);
                        currRow.append(`<td>${user?.zipcode}</td>`);
                        currRow.append(`
                        <td> 
                            <a href="show-update-user/${user.id}">
                                <button
                                  type="button"
                                   data-id='${user?.id}'
                                  class="btn btn-success btn-sm text-white edit_btn"
                                >
                                    Edit
                                </button>
                            </a>
                            
                            <button
                               type="button"
                               data-id='${user?.id}'
                               class="btn btn-danger btn-sm text-white delete_btn"
                             >
                                delete
                            </button>
                        </td>
                        `);

                        $('#table-body').append(currRow);

                    });
                },
                error: function(xhr, status, error) {
                    alert('Error :' + xhr.responseText);
                }
            })

            $(document).on('click', '.delete_btn', function() {
                let id = $(this).data('id');
                console.log("Delete user:", id);

                $.ajax({
                    url: `/delete-user/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log("user is deleted");
                    },
                    error: function(xhr, status, error) {
                        console.log('Error :' + xhr.responseText);
                    }
                })
            });

            $(document).on('click', '.edit_btn', function() {
                let id = $(this).data('id');
                console.log("Delete user:", id);

                $.ajax({
                    url: `/delete-user/${id}`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log("user is deleted");
                    },
                    error: function(xhr, status, error) {
                        console.log('Error :' + xhr.responseText);
                    }
                })
            });
        });
    </script>
@endpush
