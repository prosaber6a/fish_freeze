@extends('layouts.app')
@section('title', 'Customer')

@section('content')

    @if(session()->get('success'))
        <div class="alert alert-primary" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <form action="{{ route('update_customer', $cust->id) }}" method="post">

        @method('PUT')
        @csrf
        @foreach($errors->all() as $error)
            <div class="alert alert-warning" role="alert">
                {{ $error }}
            </div>
        @endforeach

        <div class="form-group">
            <label for="name">Name : </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="off" value="{{ $cust->name }}">
        </div>
        <div class="form-group">
            <label for="mobile">Mobile : </label>
            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" autocomplete="off" value="{{ $cust->mobile }}">
        </div>
        <div class="form-group">
            <label for="address">Address : </label>
            <textarea class="form-control" name="address" id="address" placeholder="Address" autocomplete="off">{{ $cust->address }}</textarea>
        </div>

        <div class="form-group mt-2">
            <button type="reset" class="btn btn-secondary" onclick="return confirm('Are you sure to reset?')">Reset</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>



@endsection
