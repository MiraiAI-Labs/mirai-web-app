@section('title')
    Home
@endsection

<div class="drawer-content-container">
    @if(!auth()->user()->positionChosen)

        <section class="grid grid-cols-1">
            <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center">
                <h3 class="text-lg sm:text-2xl font-semibold my-12">Posisi apa yang kamu inginkan ?</h3>
                <livewire:components.choose-position :showRecommendations="true" />
            </div>
        </section>
    @else
        <section class="w-full flex justify-center mb-4">
            <livewire:components.choose-position :showResetPosition="true" />
        </section>

        <h2 class="col-span-1 md:col-span-2 text-2xl font-bold">Dashboard</h2>

        <section class="mt-4">
            <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center">
                <h3 class="text-lg sm:text-2xl font-semibold my-12">Coming Soon</h3>
            </div>
        </section>
    @endif
</div>

@section('scripts')
    @vite('resources/js/hero-swiper.js')
@endsection
