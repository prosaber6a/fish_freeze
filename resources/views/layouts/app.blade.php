<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="/assets/bootstrap/bootstrap.css" rel="stylesheet">

    @yield('head')
</head>
<body>

@include('layouts.inc.nav')
<div class="container">
    <div class="card mt-5">
        <div class="card-header d-flex">
            <h5>@yield('title')</h5>
            <div class="control" style="margin-left: auto">
                @yield('control')
            </div>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</div>





<script src="/assets/jquery/jquery.js"></script>


<script src="/assets/bootstrap/popper.js"></script>
<script src="/assets/bootstrap/bootstrap.js"></script>

@yield('foot')

</body>
</html>
