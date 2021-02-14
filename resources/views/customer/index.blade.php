@extends('layouts.app')
@section('title', 'Customer')
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
            <th>Action</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>User</th>
        </tr>
        </thead>
        <tbody>
        @php($i = 1)
        @foreach($customer as $cust)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $cust->name }}</td>
                <td>{{ $cust->mobile }}</td>
                <td>{{ $cust->address }}</td>
                <td>
                    <a href="{{ route('edit_customer', $cust->id) }}" class="btn btn-warning btn-sm">Edit</a> &nbsp;


                    <form method="POST" action="{{ route('delete_customer', $cust->id) }}">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')">Delete</button>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('post_customer') }}" method="post">
                    <div class="modal-body">
                        @method('POST')
                        @csrf

                        @foreach($errors->all() as $error)
                            <div class="alert alert-warning" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label for="name">Name : </label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="off" value="{{ old('name')  }}">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile : </label>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" autocomplete="off" value="{{ old('mobile') }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address : </label>
                            <textarea class="form-control" name="address" id="address" placeholder="Address" autocomplete="off">{{ old('address') }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
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
            $('#datatable').DataTable();

            @if($errors->all() != null)
            $('#create_modal').modal('show');
            @endif

        });
    </script>

@endsection
