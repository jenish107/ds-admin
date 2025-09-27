@extends('layout.mainLayout')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('assets/extra-libs/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                        <form id="model-form" class="d-flex flex-column">
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

        <button class="btn btn-info mb-2" id="new-user" data-bs-toggle='modal' data-bs-target='#exampleModal'>New
            User</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let table;

        $(document).ready(async function() {
            var asyncData;
            getdata();

            function getdata() {
                const getPeople = async () => {
                    const data = await fetch("{{ route('user.list') }}");
                    const jsondata = await data.json();
                    asyncData = jsondata.data;
                    initialiseTable();
                    return jsondata;
                };
                getPeople();
            }

            function initialiseTable() {
                table = $("#data-table").DataTable({
                    data: asyncData,
                    columns: [{
                            data: "id",
                        },
                        {
                            data: 'userName',
                        },
                        {
                            data: 'first_name',
                        },
                        {
                            data: 'last_name',
                        },
                        {
                            data: 'email',
                        },
                        {
                            data: 'zipcode',
                        },
                        {
                            data: 'number',
                        },
                        {
                            data: 'action',
                        }
                    ]
                });
            }
        })
        $(document).on('click', '.edit', async function() {
            let response = await fetch($(this)?.data('url'), {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let jsondata = await response.json();

            $('#user_name').val(jsondata.userName);
            $('#email').val(jsondata.email);
            $('#number').val(jsondata.number);
            $('#zipcode').val(jsondata.zipcode);
            $('#first_name').val(jsondata.first_name);
            $('#last_name').val(jsondata.last_name);
            $('#password').val(jsondata.password);
            $('#user_id').val(jsondata.id);
            $('#update').html('Update');
        })

        document.getElementById('model-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            let form = e.target;
            let formData = new FormData(form);

            try {
                let response = await fetch("{{ route('user.save') }}", {
                    method: "POST", // or "POST" + formData.append("_method","PUT") if updating
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json"
                        // ❌ don't set Content-Type here, browser will handle it for FormData
                    },
                    // body: formData
                });

                // debug if response is not JSON
                let text = await response.json();
                console.log("Raw Response:", text);

                let data = {};
                try {
                    data = JSON.parse(text);
                    console.log("Parsed JSON:", data);
                } catch (err) {
                    console.error("Response is not JSON:", err);
                }

                const toastLiveExample = document.getElementById("liveToast");
                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();

            } catch (error) {
                console.error("Error in submit form", error);
            }

            // table.ajax.reload(); // if you use datatables
        });
        $(document).on('click', '.delete', function() {
            Swal.fire({
                title: 'are you sure to delete it',
                buttonsStyling: false,
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg mr-2',
                    cancelButton: 'btn btn-danger btn-lg',
                    loader: 'custom-loader',
                },
                loaderHtml: '<div class="spinner-border text-primary"></div>',
                preConfirm: async () => {
                    let response = await fetch($(this)?.data('url'), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    // table.ajax.reload();
                },
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
