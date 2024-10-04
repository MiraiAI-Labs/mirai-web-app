@section('title')
    Bussiness Home
@endsection

<div class="drawer-content-container">
    <h2 class="text-2xl font-bold">Bussiness Home</h2>
    <section class="mt-4 flex flex-col">
        <h1>Weekly Veterans</h1>
        <div class="flex flex-row gap-4 overflow-x-auto">
            @foreach($veterans as $veteran)
                <div class="shadow bg-base-100 rounded-xl w-full p-6 min-w-56">
                    <h1 class="text-lg font-bold text-center text-orange-gradient">{{ $veteran->name }}</h1>
                    <h1 class="text-sm font-bold text-center !bg-clip-text text-transparent class-gradient text-center" :class="theme == 'dark' ? 'dark' : 'light'">{{ $veteran->userStatistic->archetype->name }}</h1>
                </div>
            @endforeach
        </div>
    </section>

    <section class="w-full mt-6">
        {{-- <livewire:datatable model="App\Models\User" include="name" name="all-users" /> --}}
        <livewire:datatables.users-table />
    </section>
</div>

@section('scripts')
    <script></script>
@endsection
