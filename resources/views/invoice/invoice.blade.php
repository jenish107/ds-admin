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
                                action="{{ isset($invoice) ? route('updateFamily') : route('addInvoice') }}" method="POST">
                                @csrf
                                @isset($invoice)
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
                                            <input required type="text" class="form-control" name="customer_name"
                                                id="customer_name" placeholder="Enter Customer Name Here"
                                                value="{{ $obj->customer_name ?? '' }}" />
                                            @error('customer_name')
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
                                                value="{{ $invoice->customer_email ?? '' }}" name="customer_email"
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

                                    <button type="button" class="btn btn-success text-light mt-2" id="addItem">Add
                                        item</button>

                                    <div class="d-flex flex-column gap-2 mt-2">
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="subtotal" class="fw-bold">subtotal :</label>
                                            <input type="number" name="subtotal" id="subtotal" />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="discount" class="fw-bold">discount(%) :</label>
                                            <input type="number" name="discount" id="discount"
                                                value='{{ $invoice->discount ?? '' }}' />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="tax" class="fw-bold">tax(%) :</label>
                                            <input type="number" name="tax" id="tax"
                                                value='{{ $invoice->tax ?? '' }}' />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="shipping" class="fw-bold">shipping :</label>
                                            <input type="number" name="shipping" id="shipping"
                                                value='{{ $invoice->shipping ?? '' }}' />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="total" class="fw-bold">total :</label>
                                            <input type="number" name="total" id="total" />
                                        </div>
                                    </div>

                                    <input type="hidden" value="{{ $invoice->id ?? '' }}" name="id" />
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary">
                                            @isset($invoice)
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

            tr.append(`<td><select name="product_option[]" class="product_option">${options}</select></td>`);
            tr.append(`<td><input type="number" name="rate[]" class="rate" value="0" /></td>`);
            tr.append(`<td><input type="number" name="quantity[]" class="quantity" value="0" /></td>`);
            tr.append(`<td><input type="number" name="amount[]" class="amount" value="0" /></td>`);
            tr.append(`<td><button type="button" class="btn btn-sm btn-danger rounded-3 delete-row">X</button></td>`);

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

            currAmount.val(currRate.val() * currQuantity.val());
            changeSubtotal()
        }

        //update subtotal
        function changeSubtotal() {
            let subtotal = 0;
            $('.amount').each(function() {
                subtotal += parseInt($(this).val());
            });
            $('#subtotal').val(subtotal);

            changeTotal()
        }

        //update total
        function changeTotal() {
            let total = parseInt($('#subtotal').val());
            let shippingVal = parseInt($('#shipping').val()) || 0;

            total -= (($('#discount').val() * total) / 100);
            total += (($('#tax').val() * total) / 100);
            total += shippingVal;

            console.log("total ", shippingVal)
            $('#total').val(total);
        }

        $(document).on('change', '.product_option', function() {
            let currTr = $(this).closest('tr');
            let currRate = currTr.find('.rate');
            let currProduct = product.find(item => item.id == $(this).val());

            currRate.val(currProduct.price);
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
