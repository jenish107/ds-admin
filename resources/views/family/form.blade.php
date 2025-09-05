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

                    <form class="form-horizontal" action="{{ route('updateFamily') }}" method="POST">
                        @csrf
                        @if ($family)
                            @method('PUT')
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="mt-2 ms-2">
                                @if ($family)
                                    Update Family
                                @else
                                    Add Family
                                @endif
                            </h2>
                            <div class="pe-3">
                                <button type="button" class="btn btn-info" onclick="history.back();">
                                    Back
                                </button>
                            </div>
                        </div>

                        <div class="card-body pt-2">
                            <div class="form-group row mt-2">
                                <label for="first_name" class="col-md-3">first name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        placeholder="Enter first name" value="{{ $family->first_name ?? '' }}" />
                                    @error('first_name')
                                        <div>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="last_name" class="col-md-3">last name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        placeholder="Enter last name" value="{{ $family->last_name ?? '' }}" />
                                    @error('last_name')
                                        <div>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-3">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $family->email ?? '' }}"
                                        name="email" id="email" placeholder="email " />
                                    @error('email')
                                        <div>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            @if ($employId)
                                <input type="hidden" value="{{ $employId ?? '' }}" name="parentId" />
                            @endif
                            <input type="hidden" value="{{ $family->id ?? '' }}" name="id" />
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">
                                    @if ($family)
                                        Update
                                    @else
                                        Add
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- @isset($family)
            <x-form name="Family" routeName="updateFamily" :parentId="$employId" :obj="$family" />
        @else
            <x-form name="Family" routeName="addFamily" :parentId="$employId" />
        @endisset --}}
    </x-layout>
@endsection

@push('scripts')
@endpush
