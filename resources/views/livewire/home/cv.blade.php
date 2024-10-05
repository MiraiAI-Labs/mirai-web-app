@section('title')
    Curriculum Vitae Analysis
@endsection

<div class="drawer-content-container" wire:poll="pollingReviewResult">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    
    <h2 class="col-span-1 md:col-span-2 text-2xl font-bold">Curriculum Vitae Analysis</h2>

    @if($review_state == 0)
        <div class="shadow bg-base-100 rounded-xl flex justify-center items-center w-full h-64">            
            @if(!$loading)
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
            @endif

            @if($loading)
                <span class="loading loading-spinner w-16 m-auto"></span>
            @endif
        </div>
    @endif

    {{-- Reviewed --}}
    @if($review_state == 1)
        <section class="w-full h-full flex flex-row gap-4">
            <div class="w-1/2 self-start grid">
                <div class="shadow bg-base-100 rounded-xl w-full p-6">
                    <!-- Title -->
                    <h2 class="text-xl font-semibold mb-2 text-center">Overall Score</h2>
                    <div class="text-yellow-400 text-6xl font-bold text-center">{{ (int) ((($json_review['skor_peluang_diterima'] ?? 0) + ($json_review['skor_peluang_unggul_dari_kandidat_lain'] ?? 0) + ($json_review['skor_penulisan_dan_bahasa_cv'] ?? 0)) / 3) }}</div>
                    
                    <!-- Scores Section -->
                    <div class="grid gap-2 grid-cols-3 mt-4">
                        <div class="grid grid-rows-2">
                            <span class="text-center my-auto text-xs">Peluang Diterima</span>
                            <span class="text-yellow-400 text-4xl font-bold text-center">{{ $json_review['skor_peluang_diterima'] ?? '' }}</span>
                        </div>
                        
                        <div class="grid grid-rows-2">
                            <span class="text-center my-auto text-xs">Keunikan</span>
                            <span class="text-yellow-400 text-4xl font-bold text-center">{{ $json_review['skor_peluang_unggul_dari_kandidat_lain'] ?? '' }}</span>
                        </div>

                        <div class="grid grid-rows-2">
                            <span class="text-center my-auto text-xs">Gaya Penulisan</span>
                            <span class="text-yellow-400 text-4xl font-bold text-center">{{ $json_review['skor_penulisan_dan_bahasa_cv'] ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 shadow bg-base-100 rounded-xl w-full p-6">
                    <header class="text-xl font-semibold text-center">Kesimpulan</header>
                    <div class="mt-6 max-h-64 overflow-y-auto">
                        {{ Illuminate\Mail\Markdown::parse($json_review['kesimpulan'] ?? '') }}
                    </div>
                </div>

                <button class="mt-4 btn w-full btn-orange-gradient !text-black" wire:click="reupload" wire:target="reupload" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="reupload">
                        <i class="fa-solid fa-repeat"></i>
                        Reupload
                    </span>
    
                    <span class="loading loading-spinner" wire:loading wire:target="reupload"></span>
                </button>
            </div>
            <div class="w-full flex flex-col gap-4">
                <div class="shadow bg-base-100 rounded-xl w-full p-6">
                    <header class="text-xl font-semibold text-center">Peningkatan yang dapat dilakukan</header>
                    <div class="mt-6 max-h-64 overflow-y-auto">
                        {{ Illuminate\Mail\Markdown::parse($json_review['peningkatan_yang_dapat_dilakukan'] ?? '') }}
                    </div>
                </div>
                <div class="shadow bg-base-100 rounded-xl w-full p-6">
                    <header class="text-xl font-semibold text-center">Hal bagus yang dipertahankan</header>
                    <div class="mt-6 max-h-64 overflow-y-auto">
                        {{ Illuminate\Mail\Markdown::parse($json_review['hal_bagus_yang_dipertahankan'] ?? '') }}
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Still analyzing --}}
    @if($review_state == 2)
        <div class="shadow bg-base-100 rounded-xl w-full text-white">
            <header class="p-4 text-3xl font-semibold text-center">Analyzing...</header>
            <main class="px-4 pb-4 text-justify flex flex-col">
                <span class="loading loading-spinner w-16 my-6 mx-auto"></span>
                <button class="mt-4 btn w-full btn-orange-gradient !text-black" wire:click="reupload" wire:target="reupload" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="reupload">
                        <i class="fa-solid fa-repeat"></i>
                        Reupload
                    </span>
    
                    <span class="loading loading-spinner" wire:loading wire:target="reupload"></span>
                </button>
            </main>
        </div>
    @endif

    @if($review_state == 3)
        <div class="shadow bg-base-100 rounded-xl w-full text-white">
            <header class="p-4 text-3xl font-semibold text-center">Error</header>
            <main class="px-4 pb-4 text-justify flex flex-col">
                <p class="text-center">Error analyzing your CV. Please try again.</p>
                <button class="mt-4 btn w-full btn-orange-gradient !text-black" wire:click="remove" wire:target="remove" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="remove">
                        <i class="fa-solid fa-repeat"></i>
                        Reupload
                    </span>
    
                    <span class="loading loading-spinner" wire:loading wire:target="remove"></span>
                </button>
            </main>
        </div>
    @endif
</div>

@section('scripts')
    <script></script>
@endsection
