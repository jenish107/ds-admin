@extends('layout.mainLayout')

@push('style')
@endpush

@section('main')
    <x-layout>
        <div class="card">
            <div class="card-body">

                @if (session('message'))
                    <h2 class="text-success">{{ session('message') }}</h2>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <form class="form-horizontal"
                                action="{{ isset($family) ? route('updateFamily') : route('addFamily') }}" method="POST">
                                @csrf
                                @isset($family)
                                    @method('PUT')
                                @endisset

                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Invoice </h3>
                                    <div class="pe-3 ">
                                        <button type="button" class="btn btn-info" onclick="history.back();">
                                            Back
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body py-2">
                                    <div class="form-group row mt-2">
                                        <label for="name" class="col-md-3">Customer Name</label>
                                        <div class="col-sm-9">
                                            <input required type="text" class="form-control" name="name"
                                                id="name" placeholder="Enter Customer Name Here"
                                                value="{{ $obj->name ?? '' }}" />
                                            @error('name')
                                                <div>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="customer_email" class="col-md-3">Email</label>
                                        <div class="col-sm-9">
                                            <input required type="email" class="form-control"
                                                value="{{ $family->customer_email ?? '' }}" name="customer_email"
                                                id="customer_email" placeholder="Enter customer email " />
                                            @error('customer_email')
                                                <div>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="w-75">Item</th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">

                                        </tbody>
                                    </table>
                                    <div>
                                        <button type="button" class="btn btn-success text-light" id="addItem">Add
                                            item</button>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <span class="fw-bold">subtotal :</span>
                                        <span id="subtotal"> 0 </span>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <span class="fw-bold">discount(%) :</span>
                                        <input type="number" id="discount" value='0' />
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <span class="fw-bold">tax(%) :</span>
                                        <input type="number" id="tax" value='0' />
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <span class="fw-bold">shipping :</span>
                                        <input type="number" id="shipping" value='0' />
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <span class="fw-bold">total :</span>
                                        <span id="total">0</span>
                                    </div>

                                    <input type="hidden" value="{{ $family->id ?? '' }}" name="id" />
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary">
                                            @isset($family)
                                                Update
                                            @else
                                                Create
                                            @endisset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <x-slot:breadcrumb>
            <li class="breadcrumb-item"><a href="#">Home</a></li>
        </x-slot:breadcrumb>
    </x-layout>
@endsection

@push('scripts')
    <script>
        let product;
        let options = "";

        $(document).ready(function() {
            $.ajax({
                url: '/invoice/get-products',
                type: 'GET',
                success: function(response) {
                    product = response;

                    options = `<option value="select">Select</option>`;
                    response.forEach((product) => {
                        options +=
                            `<option value="${product.id}">${product.product_name}</option>`;
                    });
                    addColumn();
                },
                error: function(error) {
                    console.log('Error in get products', error);
                }
            })
        });

        function addColumn() {
            let tr = $('<tr></tr>');

            tr.append(`<td><select name="product_option" class="product_option">${options}</select></td>`);
            tr.append(`<td class="rate">0</td>`);
            tr.append(`<td><input type="number" name="quantity" class="quantity" value="0" /></td>`);
            tr.append(`<td class="amount">0</td>`);
            tr.append(`<td><button type="button" class="btn btn-danger delete-row">X</button></td>`);

            $('#tbody').append(tr);
        }
        //---- add item
        $('#addItem').click(function() {
            addColumn()
        });

        //--- delete item
        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();

            changeSubtotal();
        });

        //-- update amount
        function changeAmount(currTr) {
            let currRate = currTr.find('.rate');
            let currAmount = currTr.find('.amount');
            let currQuantity = currTr.find('.quantity');

            currAmount.html(currRate.html() * currQuantity.val());
            changeSubtotal()
        }

        //update subtotal
        function changeSubtotal() {
            let subtotal = 0;
            $('.amount').each(function() {
                subtotal += parseInt($(this).html());
            });
            $('#subtotal').html(subtotal);

            changeTotal()
        }

        //update total
        function changeTotal() {
            let total = parseInt($('#subtotal').html());
            let shippingVal = parseInt($('#shipping').val()) || 0;

            total -= (($('#discount').val() * total) / 100);
            total += (($('#tax').val() * total) / 100);
            total += shippingVal;

            console.log("total ", shippingVal)
            $('#total').html(total);
        }

        $(document).on('change', '.product_option', function() {
            let currTr = $(this).closest('tr');
            let currRate = currTr.find('.rate');
            let currProduct = product.find(item => item.id == $(this).val());

            currRate.html(currProduct.price);
            changeAmount(currTr)
        });

        $(document).on('keyup', '.quantity', function() {
            let currTr = $(this).closest('tr');
            changeAmount(currTr)
        });

        $('#discount, #tax, #shipping').on('keyup', function() {
            changeTotal();
        });
    </script>
@endpush
