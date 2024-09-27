<!DOCTYPE html>
<html
    x-data="{
        systemTheme: window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
        userTheme: $persist(null).as('userTheme'),
        get theme() {
            return this.userTheme || this.systemTheme;
        },
    }"
    x-init="window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        systemTheme = event.matches ? 'dark' : 'light';
    });"
    x-bind:data-theme="theme"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- This prevents the page from flickering when loading the user's theme because of the delay of Alpine being loaded. --}}
    <script>
        document.getElementsByTagName('html')[0].dataset.theme = JSON.parse(localStorage.getItem('userTheme')) ||
            (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        window.theme = document.getElementsByTagName('html')[0].dataset.theme;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">
    @hasSection('title')
    <title>@yield('title') - {{ config('app.name') }}</title>
    @else
    <title>{{ config('app.name') }}</title>
    @endif

    <!-- Favicon -->
    <link
        href="{{ url(asset('favicon.ico')) }}"
        rel="shortcut icon">

    <!-- Fonts -->
    <link
        href="https://rsms.me/inter/inter.css"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @livewireScripts

    <!-- CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">
</head>

<body class="poppins-regular">
    @yield('body')

    @yield('scripts')
    @if (session('toast'))
    <script defer>
        // wait for document ready
        document.addEventListener('DOMContentLoaded', function() {
            toastrToast({
                type: "{{ session('toast')['type'] ?? '' }}",
                title: "{{ session('toast')['title'] ?? '' }}",
                text: "{{ session('toast')['message'] ?? '' }}",
            })
        }, false);
    </script>
    @endif
</body>

</html>