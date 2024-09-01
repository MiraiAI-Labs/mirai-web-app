@section('title')
    Job Vacancies
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Job Vacancies</h2>
    <section class="mt-4">
        <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center">
            <h3 class="text-lg sm:text-2xl font-semibold my-12">Coming Soon</h3>
        </div>
    </section>
</div>

@section('scripts')
    @vite('resources/js/hero-swiper.js')
@endsection
