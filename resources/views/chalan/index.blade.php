@extends('layouts.app')
@section('title', 'Chalan')
@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection
@section('control')
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_modal">
        Create
    </button>
@endsection
@section('content')

    @if(session()->get('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="table-responsive">

        <table class="table table-hover table-striped " id="datatable">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Grand Total</th>
                <th>Action</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>User</th>
            </tr>
            </thead>
            <tbody>
            @php($i = 1)
            @foreach($chalans as $cln)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $cln->customer->name }}</td>
                    <td>{{ $cln->customer->mobile }}</td>
                    <td>{{ $cln->grand_quantity }} KG</td>
                    <td>৳ {{ $cln->total }}</td>
                    <td>৳ {{ $cln->discount }}</td>
                    <td>৳ {{ $cln->grand_total }}</td>
                    <td class="text-center">
                        <a href="{{ route('edit_chalan', $cln->id) }}" class="btn btn-warning">Edit</a> &nbsp;
                        <form method="POST" action="{{ route('delete_chalan', $cln->id) }}">
                            @csrf
                            @method('delete')

                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure to delete?')">Delete
                            </button>
                        </form>


                    </td>
                    <td>{{ date('F j, Y', strtotime($cln->created_at)) }}</td>
                    <td>{{ date('F j, Y', strtotime($cln->updated_at)) }}</td>
                    <td>{{ $cln->user->name }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Chalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('post_chalan') }}" method="post">
                    <div class="modal-body">
                        @method('POST')
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
                                    <input type="text" value="{{ date("d/m/Y") }}" required placeholder="dd/mm/yyyy"
                                           class="form-control" name="date" id="date"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="customer_id">Customer : </label>
                                    <select name="customer_id" id="customer_id" required class="form-select">
                                        <option value="" selected="selected" disabled>Select a customer</option>
                                        @foreach($customer as $cust)
                                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="chalan_no">Chalan No : </label>
                                    <input type="text" class="form-control" autocomplete="off" required id="chalan_no"
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
                            @for($i = 0; $i < 4; $i++)
                                <tr class="productrow-{{ $i }}">
                                    <td>
                                        <select name="product_id[]" required class="form-select" id="product_id-{{$i}}">
                                            <option value="" selected="selected">Select a product</option>
                                            @foreach($products as $_pro)
                                                <option value="{{ $_pro->id }}">{{ $_pro->name }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                    <td>
                                        <input type="text" required class="form-control" id="quantity-{{$i}}"
                                               onkeyup="subTotal({{ $i }})" name="quantity[]" value="0"
                                               autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" required class="form-control" id="rate-{{$i}}"
                                               onkeyup="subTotal({{ $i }})" name="rate[]" value="0"
                                               autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" required class="form-control disabled"
                                               style="text-align: right;"
                                               value="0" readonly id="subtotal-{{$i}}" name="subtotal[]"
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
                            <input type="hidden" name="grand_quantity" id="quantity" value="0"/>
                            <tr>
                                <td>Total:</td>
                                <td>
                                    <input type="text" class="form-control disabled" id="total" name="total" readonly
                                           value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Discount:</td>
                                <td>
                                    <input type="text" class="form-control" required id="discount"
                                           onkeyup="calcuateTotal()" autocomplete="off" name="discount" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Grand Total:</td>
                                <td>
                                    <input type="text" class="form-control disabled" id="grand_total" value="0"
                                           name="grand_total" readonly>
                                </td>
                            </tr>
                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="addRow()">Add row</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection

@section('foot')

    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').addClass('nowrap').DataTable({
                responsive: true,
            });

            @if($errors->all() != null)
            $('#create_modal').modal('show');
            @endif


        });


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
