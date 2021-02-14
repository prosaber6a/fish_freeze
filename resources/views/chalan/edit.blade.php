@extends('layouts.app')
@section('title', 'Edit Chalan')

@section('content')

    @if(session()->get('success'))
        <div class="alert alert-primary" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif



    <form action="{{ route('update_chalan', $chalan->id) }}" method="post">

        @method('PUT')
        @csrf
        @foreach($errors->all() as $error)
            <div class="alert alert-warning" role="alert">
                {{ $error }}
            </div>
        @endforeach

        <div class="row">
            <div class="col">

                <div class="form-group">
                    <label for="date">Date : </label>
                    <input type="text" value="{{ date("d/m/Y", strtotime($chalan->date)) }}" required placeholder="dd/mm/yyyy"
                           class="form-control" name="date" id="date"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="customer_id">Customer : </label>
                    <select name="customer_id" id="customer_id" required class="form-select">
                        <option value="" disabled>Select a customer</option>
                        @foreach($customer as $cust)
                            <option value="{{ $cust->id }}" @if($chalan->customer_id == $cust->id) selected @endif>{{ $cust->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="chalan_no">Chalan No : </label>
                    <input type="text" class="form-control" value="{{ $chalan->chalan_no }}" autocomplete="off" required id="chalan_no"
                           name="chalan_no" placeholder="Chalan No"/>
                </div>
            </div>
        </div>


        <hr>


        <table class="table" id="product_item_table">
            <thead>

            <tr>
                <th style="width: 25%;">Product</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Sub Total</th>
                <th style="text-align: right">Action</th>
            </tr>
            </thead>
            <tbody>
{{--            @dd($chalan->chalanitem)--}}
            @for($i = 0; $i < count($chalan->chalanitem); $i++)
                <tr class="productrow-{{ $i }}">
                    <td>
                        <select name="product_id[]" required class="form-select" id="product_id-{{$i}}">
                            <option value="">Select a product</option>
                            @foreach($products as $_pro)
                                <option value="{{ $_pro->id }}" @if($chalan->chalanitem[$i]->product_id == $_pro->id) selected @endif>{{ $_pro->name }}</option>
                            @endforeach
                        </select>

                    </td>
                    <td>
                        <input type="text" required class="form-control" id="quantity-{{$i}}"
                               onkeyup="subTotal({{ $i }})" name="quantity[]" value="{{ $chalan->chalanitem[$i]->quantity }}"
                               autocomplete="off">
                    </td>
                    <td>
                        <input type="text" required class="form-control" id="rate-{{$i}}"
                               onkeyup="subTotal({{ $i }})" name="rate[]" value="{{ $chalan->chalanitem[$i]->rate }}"
                               autocomplete="off">
                    </td>
                    <td>
                        <input type="text" required class="form-control disabled"
                               style="text-align: right;"
                               value="{{ $chalan->chalanitem[$i]->sub_total }}" readonly id="subtotal-{{$i}}" name="subtotal[]"
                               autocomplete="off">
                    </td>

                    <td>
                        <button class="btn btn-danger" type="button" onclick="removeRow({{ $i }})">X
                        </button>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>


        <table class="table w-50 table-bordered" style="margin-left: auto;">
            <input type="hidden" name="grand_quantity" id="quantity" value="{{ $chalan->grand_quantity }}"/>
            <tr>
                <td>Total:</td>
                <td>
                    <input type="text" class="form-control disabled" id="total" name="total" readonly
                           value="{{ $chalan->total }}">
                </td>
            </tr>
            <tr>
                <td>Discount:</td>
                <td>
                    <input type="text" class="form-control" required id="discount"
                           onkeyup="calcuateTotal()" autocomplete="off" name="discount" value="{{ $chalan->discount }}">
                </td>
            </tr>
            <tr>
                <td>Grand Total:</td>
                <td>
                    <input type="text" class="form-control disabled" id="grand_total" value="{{ $chalan->grand_total }}"
                           name="grand_total" readonly>
                </td>
            </tr>
        </table>

        <div class="form-group mt-2 d-block" style="margin-left: auto;text-align: right;">
            <button type="button" class="btn btn-success" onclick="addRow()">Add row</button>
            <button type="reset" class="btn btn-secondary" onclick="return confirm('Are you sure to reset?')">Reset
            </button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>



@endsection


@section('foot')

    <script>

        function subTotal(row = null) {
            let quantity = parseFloat($("#quantity-" + row).val());
            let rate = parseFloat($("#rate-" + row).val());
            $("#subtotal-" + row).val((quantity * rate).toFixed(2));
            calcuateTotal();
        }

        function calcuateTotal() {
            let tablelength = $('#product_item_table tbody tr').length;
            let total = 0.00;
            let quantity = 0.00;
            let discount = parseFloat($("#discount").val());
            for (i = 0; i < tablelength; i++) {
                total += parseFloat($("#subtotal-" + i).val());
                quantity += parseFloat($("#quantity-" + i).val());
            }
            $("#total").val(total.toFixed(2));
            $("#quantity").val(quantity.toFixed(3));
            $("#grand_total").val((total - discount).toFixed(2));
        }

        function addRow() {
            let tablelength = $('#product_item_table tbody tr').length;
            let tr = "";
            tr += `
            <tr class="productrow-${tablelength}">
                <td>
                    <select name="product_id[]" required class="form-select" id="product_id-${tablelength}">
                        <option value="" selected="selected">Select a product</option>
                        @foreach($products as $_pro)
            <option value="{{ $_pro->id }}">{{ $_pro->name }}</option>
                        @endforeach
            </select>

        </td>
        <td>
                                        <input type="text" class="form-control" required id="quantity-${tablelength}" onkeyup="subTotal(${tablelength})" name="quantity[]" value="0"
                                               autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" required id="rate-${tablelength}" onkeyup="subTotal(${tablelength})" name="rate[]" value="0"
                                               autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control disabled" required style="text-align: right;" value="0" readonly id="subtotal-${tablelength}" name="subtotal[]"
                                               autocomplete="off">
                                    </td>

        <td>
            <button class="btn btn-danger" role="button" onclick="removeRow(${tablelength})">X</button>
                    </td>
                </tr>
            `;

            if (tablelength > 0) {
                $("#product_item_table tbody tr:last").after(tr);
            } else {
                $("#product_item_table tbody").append(tr);
            }
        }


        function removeRow(row = null) {
            // console.log('s')
            if (row) {
                $(".productrow-" + row).remove();
                calcuateTotal();
            } else {
                alert('error! Refresh the page again');
            }
        }


    </script>

@endsection

