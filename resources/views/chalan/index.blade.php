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

    <table class="table table-hover table-striped" id="datatable">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Qty</th>
            <th>Subtotal</th>
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
                <td>{{ $cln->customer->address }}</td>
                <td class="d-flex">
                    <a href="{{ route('edit_customer', $cust->id) }}" class="btn btn-warning">Edit</a> &nbsp;


                    <form method="POST" action="{{ route('delete_customer', $cust->id) }}">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure to delete?')">Delete
                        </button>
                    </form>


                </td>
                <td>{{ date('F j, Y, g:i a', strtotime($cust->created_at)) }}</td>
                <td>{{ date('F j, Y, g:i a', strtotime($cust->updated_at)) }}</td>
                <td>{{ $cust->user->name }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>


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

                        <div class="form-group">
                            <label for="customer_id">Customer : </label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                <option value="" selected="selected">Select a customer</option>
                                @foreach($customer as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                @endforeach
                            </select>
                        </div>


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
                                        <select name="product_id[]" class="form-control" id="product_id[]">
                                            <option value="" selected="selected">Select a product</option>
                                            @foreach($products as $_pro)
                                                <option value="{{ $_pro->id }}">{{ $_pro->name }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="quantity-{{$i}}" name="quantity[]" value="0"
                                               autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="rate-{{$i}}" name="rate[]" value="0"
                                               autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-plaintext" readonly id="subtotal-{{$i}}" name="subtotal[]"
                                               autocomplete="off">
                                    </td>

                                    <td>
                                        <button class="btn btn-danger" type="button" onclick="removeRow({{ $i }})">X</button>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
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
            // $('#datatable').DataTable();

            @if($errors->all() != null)
            $('#create_modal').modal('show');
            @endif

        });

        function addRow() {
            let tablelength = $('#product_item_table tbody tr').length;
            let tr = "";
            tr += `
            <tr class="productrow-${tablelength}">
                <td>
                    <select name="product_id[]" class="form-control" id="product_id[]">
                        <option value="" selected="selected">Select a product</option>
                        @foreach($products as $_pro)
            <option value="{{ $_pro->id }}">{{ $_pro->name }}</option>
                        @endforeach
            </select>

        </td>
        <td>
            <input type="text" class="form-control" id="quantity-${tablelength}" name="quantity[]" value="0" autocomplete="off">
        </td>
        <td>
            <input type="text" class="form-control" id="rate-${tablelength}" name="rate[]" value="0" autocomplete="off">
        </td>
        <td>
            <input type="text" class="form-control" id="subtotal-${tablelength}" name="subtotal[]" value="0" autocomplete="off">
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
            } else {
                alert('error! Refresh the page again');
            }
        }


    </script>

@endsection
