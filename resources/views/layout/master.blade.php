<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta')

        <link rel="shortcut icon" href="{{ asset('assets/images/favion.png') }}">
        <title>@yield('title') | {{env('APP_NAME')}}</title>
        @include('layouts.header-css')
    </head>

    <body>
        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')
    </body>
</html>
