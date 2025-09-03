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
                    <form class="form-horizontal" action="{{ route('UpdateUser') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

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
                                        value="{{ $user->country }}" name="country" style="width: 100%; height: 36px">
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
                                    <input type="text" name="zipcode" value="{{ $user->zipcode }}" class="form-control"
                                        id="zipcode" placeholder="Enter zipcode" />
                                </div>
                            </div>

                            <input type="hidden" value="{{ $user->id }}" name="id" />
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
    <script>
        $(document).ready(function() {
            let userCountryId = {{ $user->country_id ?? 'null' }};
            let userStateId = {{ $user->state_id ?? 'null' }};
            let userCityId = {{ $user->city_id ?? 'null' }};

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
                error: function(error) {
                    alert("Failed to load countries", error);
                }
            });
            loadStates(userCountryId)

            $('#country').change(function() {
                loadStates($(this).val())
            })

            $('#state').change(function() {
                loadCities($(this).val())
            })

            function loadStates(countryId) {
                $.ajax({
                    url: `/get-state/${countryId}`,
                    type: 'GET',
                    success: function(data) {
                        $('#state').empty().append('<option>Select</option>');
                        $.each(data, function(index, state) {
                            let selected = (state.id === userStateId) ? 'selected' : '';
                            $('#state').append(
                                `<option value="${state.id}" ${selected}>${state.name}</option>`
                            );
                        });

                        // Automatically load cities if a state is pre-selected
                        if (selectedStateId) {
                            loadCities(selectedStateId, userCityId);
                        }
                    },
                    error: function(error) {
                        console.log("error in get state", error);
                    }
                });
            }

            function loadCities(stateId) {
                $.ajax({
                    url: `/get-city/${stateId}`,
                    type: 'GET',
                    success: function(data) {
                        $('#city').empty().append('<option>Select</option>');
                        $.each(data, function(index, city) {
                            let selected = (city.id === userCityId) ? 'selected' : '';
                            $('#city').append(
                                `<option value="${city.id}" ${selected}>${city.name}</option>`
                            );
                        });
                    },
                    error: function(error) {
                        console.log("error in get city", error);
                    }
                });
            }

        })
    </script>
@endpush
