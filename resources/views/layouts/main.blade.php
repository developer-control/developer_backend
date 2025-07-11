<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.header', ['title' => @$title ?? config('app.name', 'Developer Control')])
    @yield('style')
    @stack('css')
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('sweetalert::alert')
    @include('layouts.sidebar', [
        'menu' => @$menu ?? 'dashboard',
        'submenu' => @$submenu ?? '',
    ])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        @yield('content')
    </main>
    @include('layouts.setting')
    @include('layouts.footer')
    @include('layouts.script')
    @yield('scripts')
    @stack('js')
</body>

</html>
