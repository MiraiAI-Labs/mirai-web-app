@section('title')
    Curriculum Vitae Analysis
@endsection

<div class="drawer-content-container">
    <h3 class="col-span-1 md:col-span-2 text-2xl font-bold">Curriculum Vitae Analysis</h3>
    <section class="grid grid-cols-1 md:grid-cols-2 gap-4 h-4/5 mt-4">
        <div class="bg-base-100 rounded-xl flex justify-center items-center">
            <input type="file" class="file-input file-input-bordered w-full max-w-xs pop-anim" />
        </div>
        <div class="bg-base-100 rounded-xl min-h-80">
            <header class="p-4 text-xl font-semibold text-center">Analysis Result</header>
            <main class="px-4 pb-4 text-justify">
            </main>
        </div>
    </section>
</div>

@section('scripts')
    @vite('resources/js/hero-swiper.js')
@endsection
