<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - DKM AL HIKMAH</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/dkm/dkm-logo-white.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">
    <link href="{{ asset('assets/plugins/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @include('admin.layout.css')

    @yield('css')
</head>

<body>
    <div class="admin-shell">

        @include('admin.layout.sidebar')

        <main class="admin-main">

            @include('admin.layout.header')

            <section class="admin-content">
                @yield('content')
            </section>

            @include('admin.layout.footer')

        </main>
    </div>

    @include('admin.layout.js')

    @yield('script')
</body>
</html>