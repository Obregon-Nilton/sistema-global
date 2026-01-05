<!-- views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    <div class="layout">
        @include('partials.sidebar')
        <main>
            @yield('content')
        </main>
    </div>

    @include('partials.footer')
    <div id="toast" class="toast"></div>

    @yield('scripts')
</body>
</html>
