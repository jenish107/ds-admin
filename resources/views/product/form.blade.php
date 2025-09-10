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

                    <form class="form-horizontal"
                        action="{{ isset($product) ? route('updateProduct') : route('addProduct') }}" method="POST">
                        @csrf
                        @isset($product)
                            @method('PUT')
                        @endisset

                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="mt-2 ms-2">
                                @isset($product)
                                    Update Product
                                @else
                                    Add Product
                                @endisset
                            </h2>
                            <div class="pe-3">
                                <button type="button" class="btn btn-info" onclick="history.back();">
                                    Back
                                </button>
                            </div>
                        </div>

                        <div class="card-body pt-2">
                            <div class="form-group row mt-2">
                                <label for="product_name" class="col-md-3">Product Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                        placeholder="Enter product name" value="{{ $product->product_name ?? '' }}" />
                                    @error('product_name')
                                        <div>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="price" class="col-md-3">price</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="price" id="price"
                                        placeholder="Enter price" value="{{ $product->price ?? '' }}" />
                                    @error('price')
                                        <div>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" value="{{ $product->id ?? '' }}" name="id" />
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">
                                    @isset($product)
                                        Update
                                    @else
                                        Add
                                    @endisset
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
