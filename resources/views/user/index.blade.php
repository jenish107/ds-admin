@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <x-layout>
        {{-- toaster --}}
        <div class="toast-container position-fixed fixed-top p-6 " style="z-index: 9999999">
            <div class="toast" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex gap-4">
                        <span><i class="fa-solid fa-circle-check fa-lg icon-success"></i></span>
                        <div class="d-flex flex-column flex-grow-1 gap-2">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold">Your changes were saved</span>
                                <button type="button" class="btn-close btn-close-sm ms-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="model-form" class="d-flex flex-column">
                            @csrf
                            <label for="user_name">User Name</label>
                            <input type="text" name="userName" id="user_name">

                            <label for="email">Email</label>
                            <input type="text" name="email" id="email">

                            <label for="password">password</label>
                            <input type="text" name="password" id="password">

                            <label for="number">Number</label>
                            <input type="text" name="number" id="number">

                            <label for="zipcode">zipcode</label>
                            <input type="text" name="zipcode" id="zipcode">

                            <label for="first_name">first name</label>
                            <input type="text" name="first_name" id="first_name">

                            <label for="last_name">last name</label>
                            <input type="text" name="last_name" id="last_name">

                            <input type="hidden" name="user_id" id="user_id">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="update" class="btn btn-primary">Create </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-info" id="new-user" data-bs-toggle='modal' data-bs-target='#exampleModal'>New User</button>
        <div class="table-responsive w-100">
            <table id="data-table" class="table table-striped table-bordered w-100 min-w-25">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>User Name</th>
                        <th>First name</th>
                        <th>last name</th>
                        <th>Email</th>
                        <th>zipcode</th>
                        <th>Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </x-layout>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        let table;
        $(document).ready(function() {
            table = $('#data-table').DataTable({
                ajax: {
                    url: "{{ route('user.list') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'userName',
                        name: 'userName'
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
                        data: 'zipcode',
                        name: 'zipcode'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            })
        })

        $(document).on('click', '.delete', function() {
            var url = "{{ route('user.destroy', ':id') }}";
            let currId = $(this)?.data('id');
            url = url.replace(':id', currId);
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    console.log('Data is deleted', response);
                }
            })
        })
        $(document).on('click', '.edit', function() {
            var url = "{{ route('user.show', ':id') }}";
            let currId = $(this)?.data('id');
            url = url.replace(':id', currId);

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $('#user_name').val(response.userName);
                    $('#email').val(response.email);
                    $('#number').val(response.number);
                    $('#zipcode').val(response.zipcode);
                    $('#first_name').val(response.first_name);
                    $('#last_name').val(response.last_name);
                    $('#password').val(response.password);
                    $('#user_id').val(response.id);
                    $('#update').html('Update');
                }
            })
        })
        $('#model-form').submit(function(e) {
            e.preventDefault();
            console.log('form submit')

            $.ajax({
                url: "{{ route('user.edit.create') }}",
                type: "PUT",
                data: $(this).serialize(),
                success: function(response) {
                    console.log("Data is updated");
                    const toastLiveExample = document.getElementById("liveToast");
                    const toast = new bootstrap.Toast(toastLiveExample);
                    toast.show();
                    // const toastTrigger = document.getElementById('liveToastBtn')
                    // const toastLiveExample = document.getElementById('liveToast')

                    // if (toastTrigger) {
                    //     toastTrigger.addEventListener('click', () => {
                    //         toastBootstrap.show()
                    //     })
                    // }
                    table.ajax.reload();
                }
            })
        })
        $('#new-user').click(function() {
            $('#user_name').val("");
            $('#email').val("");
            $('#number').val("");
            $('#zipcode').val("");
            $('#first_name').val("");
            $('#last_name').val("");
            $('#password').val("");
            $('#user_id').val("");
            $('#update').html('Create');
        })
    </script>
@endpush
