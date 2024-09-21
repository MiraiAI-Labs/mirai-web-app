@section('title')
    Curriculum Vitae Analysis
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="col-span-1 md:col-span-2 text-2xl font-bold">Curriculum Vitae Analysis</h2>
    <section class="flex gap-4 mt-4 max-h-screen flex-col sm:flex-row">
        <div class="shadow bg-base-100 rounded-xl flex justify-center items-center w-full sm:w-1/4">            
            <div class="flex items-center justify-center w-full h-full pop-anim">
                <label for="dropzone-file" class="p-6 flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 text-center"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    </div>
                    <input id="dropzone-file" type="file" wire:model="cv" class="hidden file-input file-input-bordered w-full max-w-xs " />
                </label>
            </div> 
        </div>
        <div class="shadow bg-base-100 rounded-xl min-h-80 w-full sm:w-3/4 max-h-svh flex flex-col">
            <header class="p-4 text-xl font-semibold text-center">Analysis Result</header>
            <main class="px-4 pb-4 text-justify overflow-y-scroll flex min-h-[300px] flex-col" wire:poll="pollingReviewResult">
                {{ Illuminate\Mail\Markdown::parse($review ?? '') }}
                <span class="loading loading-spinner w-16 {{ $loading ? 'block' : 'hidden' }} m-auto"></span>
            </main>
        </div>
    </section>
</div>

@section('scripts')
    @vite('resources/js/hero-swiper.js')
@endsection
