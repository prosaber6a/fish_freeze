@extends('layouts.app')
@section('title', 'Product')

@section('content')

    @if(session()->get('success'))
        <div class="alert alert-primary" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <form action="{{ route('update_product', $pro->id) }}" method="post">

        @method('PUT')
        @csrf
        @foreach($errors->all() as $error)
            <div class="alert alert-warning" role="alert">
                {{ $error }}
            </div>
        @endforeach

        <div class="form-group">
            <label for="name">Name : </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="off" value="{{ $pro->name }}">
        </div>

        <div class="form-group mt-2">
            <button type="reset" class="btn btn-secondary" onclick="return confirm('Are you sure to reset?')">Reset</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>



@endsection
