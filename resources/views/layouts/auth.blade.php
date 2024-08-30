@extends('layouts.base')

@section('body')
    <div class="bg-base-100 flex min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
    <div class="fixed bottom-4 right-4">
        <x-theme-selector class="dropdown-top dropdown-end" />
    </div>
@endsection
