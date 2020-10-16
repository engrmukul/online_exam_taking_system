<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.styles')
    @yield('styles')
</head>

<body>
<div id="wrapper">
    @if( auth()->user()->is_password_changed == 'yes' )
        @include('partials.sidebar')
    @endif
    <div id="page-wrapper" class="gray-bg">
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
    </div>
</div>
@include('partials.scripts')
@stack('scripts')

</body>
</html>
