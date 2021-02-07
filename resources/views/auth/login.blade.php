@extends('layouts.app')
@section('title', 'Login')
@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf


        @foreach($errors->all() as $error)
            <div class="alert alert-warning" role="alert">
                <strong>Error!</strong> {{ $error }}
            </div>
        @endforeach


        <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-sm-9 offset-sm-3">
                <button type="reset" class="btn btn-warning" onclick="return confirm('Are you sure to reset?')">Reset</button>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </form>

@endsection
