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
                                action="{{ isset($invoice) ? route('updateInvoice') : route('addInvoice') }}" method="POST">
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
                                                value="{{ old('customer_name', $invoice->customer_name ?? '') }}" />
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
                                                value="{{ old('customer_email', $invoice->customer_email ?? '') }}"
                                                name="customer_email" id="customer_email"
                                                placeholder="Enter customer email " />
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
                                        <tbody id="tbody" class="form-group">
                                        </tbody>
                                    </table>

                                    <button type="button" class="btn btn-success text-light mt-2" id="addItem">Add
                                        item</button>

                                    <div class="d-flex flex-column gap-2 mt-2">
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="subtotal" class="fw-bold">subtotal :</label>
                                            <input style="width: 10rem" class="form-control" type="number" name="subtotal"
                                                id="subtotal" readonly
                                                value='{{ old('subtotal', $invoice->subtotal ?? 0) }}' />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="discount" class="fw-bold">discount(%) :</label>
                                            <input style="width: 10rem" class="form-control" type="number" name="discount"
                                                id="discount" value='{{ old('discount', $invoice->discount ?? 0) }}' />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="tax" class="fw-bold">tax(%) :</label>
                                            <input style="width: 10rem" class="form-control" type="number" name="tax"
                                                id="tax" value="{{ old('tax', $invoice->tax ?? 0) }}" />
                                        </div>

                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="shipping" class="fw-bold">shipping :</label>
                                            <input style="width: 10rem" class="form-control" type="number" name="shipping"
                                                id="shipping" value="{{ old('shipping', $invoice->shipping ?? 0) }}" />
                                        </div>

                                        <div class="d-flex justify-content-end gap-2">
                                            <label for="total" class="fw-bold">total :</label>
                                            <input style="width: 10rem" class="form-control" type="number" name="total"
                                                id="total" readonly value="{{ old('total', $invoice->total ?? 0) }}" />
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
        let invoice = @json($invoice->invoiceItem ?? []);

        function loadProductOptions(selectElement, selectedId = null) {
            selectElement.append(`<option value="">Select</option>`);

            var product_ids = $('.product_option').map(function() {
                return Number(this.value);
            }).get();

            product.forEach((product) => {
                if (!product_ids.includes(product.id)) {
                    let isSelected = (selectedId && selectedId == product.id) ? 'selected' : '';
                    selectElement.append(
                        `<option value="${product.id}" ${isSelected}>${product.product_name}</option>`
                    );
                }
            });
        }
        $(document).ready(function() {
            $.ajax({
                url: '/invoice/get-products',
                type: 'GET',
                success: function(response) {
                    product = response;
                    if (invoice.length == 0) {
                        addColumn()
                    } else {
                        loadColumn()
                    }
                },
                error: function(error) {
                    console.log('Error in get products', error);
                }
            })
        });

        function loadColumn() {
            invoice.forEach((item) => {
                addColumn(item);
            });
        }

        function addColumn(item = null) {
            let tr = $('<tr></tr>');
            let currIndex = $('#tbody').children().length;

            tr.append(
                `<td><select name="items[${currIndex}][product_option]" class="product_option form-select"></select></td>`
            );
            let currOption = tr.find('.product_option');
            loadProductOptions(currOption, item?.product_id);

            tr.append(
                `<td><input type="number" style="width: 6rem"  name="items[${currIndex}][rate]" class="rate form-control" readonly value="${item ? item['product']['price'] : 0}" /></td>`
            );
            tr.append(
                `<td><input type="number" style="width: 6rem"  name="items[${currIndex}][quantity]" data-index="${currIndex}" class="quantity form-control" value="${item ? item['quantity'] : 1}" /> 
                <div class="text-danger visually-hidden" id="quantity-alert-${currIndex}">
                    Enter Quantity
                </div></td>`
            );
            tr.append(
                `<td><input type="number" style="width: 6rem"  name="items[${currIndex}][amount]" class="amount form-control" readonly value="${item ? item['amount'] : 0}" /></td>`
            );
            tr.append(
                `<td class="d-flex align-items-center"><button type="button" class="btn btn-sm btn-danger rounded-3 delete-row">X</button></td>`
            );

            $('#tbody').append(tr);
            toggleDelete();
        }

        function toggleDelete() {
            if ($('#tbody').children().length <= 1) {
                $('#tbody tr .delete-row').remove()
            } else {
                if ($('#tbody tr:first td:last').is(':empty')) {
                    $('#tbody tr:first td:last').append(
                        `<button type="button" class="btn btn-sm btn-danger rounded-3 delete-row">X</button>`)
                }
            }
        }

        //---- add item
        $('#addItem').click(function() {
            let flag = 0;

            $('.rate').each(function() {
                if ($(this).val() == 0) {
                    // alert('Enter item')
                    $(this).removeClass('visually-hidden')
                    flag = 1;
                }
            })
            $('.quantity').each(function() {
                flag = checkQuantity($(this));
            })
            if (flag == 0) {
                addColumn()
            }
        });

        //--- check is quntity
        function checkQuantity(field) {
            let index = $(field).data('index');
            console.log('$(field).val() --', $(field).val());
            if ($(field).val() > 0) {
                $(`#quantity-alert-${index}`).addClass('visually-hidden')
                return 0;
            } else {
                $(`quantity-alert-${index}`).removeClass('visually-hidden');
                return 1;
            }
        }

        //--- delete item
        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            toggleDelete();
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
            checkQuantity($(this))
            changeAmount(currTr)
        });

        $('#discount, #tax, #shipping').on('keyup', function() {
            changeTotal();
        });
    </script>
@endpush
