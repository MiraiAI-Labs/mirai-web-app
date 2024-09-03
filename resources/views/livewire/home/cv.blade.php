@section('title')
    Curriculum Vitae Analysis
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="col-span-1 md:col-span-2 text-2xl font-bold">Curriculum Vitae Analysis</h2>
    <section class="grid grid-cols-1 md:grid-cols-2 gap-4 h-4/5 mt-4">
        <div class="bg-base-100 rounded-xl flex justify-center items-center">
            <input type="file" wire:model="cv" class="file-input file-input-bordered w-full max-w-xs pop-anim" />
        </div>
        <div class="bg-base-100 rounded-xl min-h-80">
            <header class="p-4 text-xl font-semibold text-center">Analysis Result</header>
            <main class="px-4 pb-4 text-justify overflow-y-scroll max-h-[300px] flex h-[300px] flex-col" wire:poll="pollingReviewResult">
                {{ Illuminate\Mail\Markdown::parse($review ?? '') }}
                <span class="loading loading-spinner w-16 {{ $loading ? 'block' : 'hidden' }} m-auto"></span>
            </main>
        </div>
    </section>
</div>

@section('scripts')
    @vite('resources/js/hero-swiper.js')
@endsection
