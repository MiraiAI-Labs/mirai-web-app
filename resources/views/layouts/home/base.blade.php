
@extends('layouts.base')

@section('body')
    <div>
        @include('layouts.home.navbar', ['activeTab' => $activeTab ?? 'home'])
        <div class="drawer lg:drawer-open pt-16 bg-base-200">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content lg:ml-56">
                <!-- Page content here -->
                @yield('content')

                @isset($slot)
                    {{ $slot }}
                @endisset

                @include('layouts.home.footer')
            </div>

            {{-- @include('layouts.home.sidebar') --}}
            <livewire:components.sidebar :activeTab="$activeTab ?? 'home'"/>
        </div>
    </div>
@endsection
