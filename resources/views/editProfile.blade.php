@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        @if (session('message'))
            <h2 class="text-success">{{ session('message') }}</h2>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('updateProfile') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <h4 class="card-title">Personal Info</h4>
                            <div>
                                <img id="previewImage" src="{{ asset('uploads/' . $user->image) }}" height="100"
                                    width="100" alt="Profile Image" />
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-md-3">Upload img</label>
                                <div class="col-md-9">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input"
                                            id="validatedCustomFile" />
                                        <label class="custom-file-label" for="validatedCustomFile">Choose img...</label>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="userName" class="col-md-3">User name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="userName" disabled id="userName"
                                        placeholder="First Name Here" value="{{ $user->userName }}" />
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="password" class="col-md-3">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" disabled class="form-control" name="password" id="password"
                                        placeholder="First Name Here" value="{{ $user->password }}" />
                                    <a href="{{ route('changePasswordPage') }}" class="btn border btn-info">change
                                        password</a>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="email" class="col-md-3">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="First Name Here" value="{{ $user->email }}" />
                                </div>
                            </div>


                            <div class="form-group row mt-3">
                                <label for="fname" class="col-md-3">First
                                    Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="first_name" id="fname"
                                        placeholder="First Name Here" value="{{ $user->first_name }}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-md-3">Last
                                    Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->last_name }}"
                                        name="last_name" id="lname" placeholder="Last Name Here" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="number" class="col-md-3">Contact No</label>
                                <div class="col-sm-9">
                                    <input type="text" name="number" value="{{ $user->number }}" class="form-control"
                                        id="number" placeholder="Contact No Here" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3">Select country</label>
                                <div class="col-md-9">
                                    <select class="select2 form-select shadow-none" id="country"
                                        value="{{ $user->country }}" name="" style="width: 100%; height: 36px">
                                        <option value="">Select</option>
                                        @if ($user->country)
                                            <option value="{{ $user->country->id }}" selected>{{ $user->country->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3">Select state</label>
                                <div class="col-md-9">
                                    <select class="select2 form-select shadow-none" id="state" name="state"
                                        style="width: 100%; height: 36px">
                                        <option value="">Select</option>
                                        @if ($user->state)
                                            <option value="{{ $user->state->id }}" selected>{{ $user->state->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3">Enter city</label>
                                <div class="col-md-9">
                                    <select class="select2 form-select shadow-none" id="city" name="city"
                                        style="width: 100%; height: 36px">
                                        <option value="">Select</option>
                                        @if ($user->city)
                                            <option value="{{ $user->city->id }}" selected>{{ $user->city->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3">Enter zipcode</label>
                                <div class="col-md-9">
                                    <input type="text" name="zipcode" value="{{ $user->zipcode }}"
                                        class="form-control" id="zipcode" placeholder="Enter zipcode" />
                                </div>
                            </div>

                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
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
    <!-- This Page JS -->
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/mask/mask.init.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-asColor/dist/jquery-asColor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-asGradient/dist/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/quill/dist/quill.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let userCountryId = {{ $user->country_id ?? 'null' }};
            let userStateId = {{ $user->state_id ?? 'null' }};
            let userCityId = {{ $user->city_id ?? 'null' }};

            $('#validatedCustomFile').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            $.ajax({
                url: "/get-countries",
                type: "GET",
                success: function(data) {
                    $('#country').empty().append('<option>Select</option>')

                    $.each(data, function(index, country) {
                        let selected = (country.id === userCountryId) ? 'selected' : '';
                        $('#country').append(
                            `<option value="${country.id}" ${selected}>${ country.name }</option>`
                        );
                    });
                },
                error: function() {
                    alert("Failed to load countries");
                }
            });

            $('#country').change(function() {
                $.ajax({
                    url: `/get-state/${$(this).val()}`,
                    type: 'GET',
                    success: function(data) {

                        $('#state').empty().append(`<option>Select</option>`);

                        $.each(data, function(index, state) {
                            $('#state').append(
                                `<option value="${state.id}">${state.name}</option>`
                            )
                        })
                    },
                    error: function(error) {
                        console.log("error in get state", error)
                    }
                })
            })

            $('#state').change(function() {
                $.ajax({
                    url: `/get-city/${$(this).val()}`,
                    type: 'GET',
                    success: function(data) {
                        console.log("data 0----", data)
                        $('#city').empty().append(`<option>Select</option>`);

                        $.each(data, function(index, city) {
                            $('#city').append(
                                `<option value="${city.id}">${city.name}</option>`
                            )
                        })
                    },
                    error: function(error) {
                        console.log("error in get city", error)
                    }
                })
            })
        })
    </script>
@endpush
