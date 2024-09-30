@section('title')
    Home
@endsection

<div class="drawer-content-container" x-data="archetype_article">
    <div id="dashboard" x-cloak x-show="!article">
        @if(!auth()->user()->positionChosen)
            <section class="grid grid-cols-1">
                <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center">
                    <h3 class="text-lg sm:text-2xl font-semibold my-12">Posisi apa yang kamu inginkan ?</h3>
                    <livewire:components.choose-position :showRecommendations="true" :home="true" />
                </div>
            </section>
        @else
            <h2 class="col-span-1 md:col-span-2 text-4xl font-bold !bg-clip-text text-transparent bw-gradient" :class="theme == 'dark' ? 'dark' : 'light'">Selamat datang, Ranger {{ auth()->user()->first_name }}.</h2>
            <h2 class="col-span-1 md:col-span-2 text-xl font-light">Kami telah menunggumu. Mari kita mulai perjalanannya!</h2>
            
            <section class="w-full flex justify-center my-4">
                <livewire:components.choose-position :showResetPosition="true" class="!w-full"/>
            </section>
    
            <section class="mt-4" x-data="job_analysis" wire:poll="pollFetched">
                <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center" x-cloak x-show="!fetched">
                    <button class="btn btn-lg btn-neutral" x-cloak x-show="!fetched && !fetching" x-on:click="fetch()">Fetch Analysis</button>
                    <span class="loading loading-spinner w-16" x-cloak x-show="fetching"></span>
                </div>
    
                @if($this->analysis_json)
                
                <div x-cloak x-show="fetched" class="grid grid-cols-8 grid-rows-1 gap-3">
    
                    <livewire:components.UserClass class="row-span-1 col-span-3"/>
                    
                    <livewire:components.UserPerformance class="row-span-1 col-span-2"/>
                    
                    <div id="indicators-carousel" class="relative w-full row-span-1 col-span-3" data-carousel="static" wire:ignore>
                        <!-- Carousel wrapper -->
                        <div class="relative overflow-hidden rounded-lg h-full">
    
                            <div class="w-full duration-700 ease-in-out" data-carousel-item="active">
                                <div x-cloak x-show="fetched" class="w-full shadow bg-base-100 rounded-xl flex justify-center items-center w-full h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Job Wordcloud</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.wordcloud class="my-auto" :data="$analysis_json['wordcloud_data']" wire:key="wordcloud_data" />
                                    </div>
                                </div>
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Top Locations</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.bar class="my-auto" :data="$analysis_json['top10_job_locs']" wire:key="top10_job_locs" />
                                    </div>
                                </div>    
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Most Similar Job Titles</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.bar class="my-auto" :data="$analysis_json['top_job_titles']" wire:key="top_job_titles" :isVertical="false"/>
                                    </div>
                                </div>
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Industries With Most Jobs</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.bar class="my-auto" :data="$analysis_json['top10_industries_with_most_jobs']" wire:key="top10_industries_with_most_jobs" :isVertical="false"/>
                                    </div>
                                </div>
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Most Mentioned Tech Stacks in Job Descriptions</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.bar class="my-auto" :data="array_slice($analysis_json['most_mentioned_skills_and_techstacks'], 0, 10)" wire:key="most_mentioned_skills_and_techstacks" :isVertical="false"/>
                                    </div>
                                </div>
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Most Remote Job Titles</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.bar class="my-auto" :data="$analysis_json['top10_remote_jobs']" wire:key="top10_remote_jobs" :isVertical="false"/>
                                    </div>
                                </div>
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Most Non-Remote Job Titles</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.bar class="my-auto" :data="$analysis_json['top10_non_remote_jobs']" wire:key="top10_non_remote_jobs" :isVertical="false"/>
                                    </div>
                                </div>
                            </div>
    
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Job Posting Trends Over Time</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.line class="my-auto" :data="$analysis_json['job_post_trend']" wire:key="job_post_trend" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="hidden w-full duration-700 ease-in-out" data-carousel-item>
                                <div x-cloak x-show="fetched" class="absolute w-full shadow bg-base-100 rounded-xl flex justify-center items-center h-full p-8 flex-col items-center">
                                    <h2 class="text-xl font-bold mb-4">Tech Trends Over Time</h2>
                                    <div class="w-full h-full flex justify-center relative">
                                        <livewire:components.line class="my-auto" :data="$analysis_json['tech_stacks_overtime']" wire:key="tech_stacks_overtime" :multiple="true"/>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                        <!-- Slider indicators -->
                        <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 6" data-carousel-slide-to="5"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 7" data-carousel-slide-to="6"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 8" data-carousel-slide-to="7"></button>
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 9" data-carousel-slide-to="8"></button>
                        </div>
                        <!-- Slider controls -->
                        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full dark:bg-white/30 dark:group-hover:bg-white/50 bg-gray-800/30 group-hover:bg-gray-800/50">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full dark:bg-white/30 dark:group-hover:bg-white/50 bg-gray-800/30 group-hover:bg-gray-800/50">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                </div>
                @endif
            </section>
        @endif
    </div>

    <div id="archetype-article" x-cloak x-show="article">
        <livewire:components.archetype-article :showRecommendations="true" />
    </div>
</div>

@section('scripts')
    @vite('resources/js/chart.js')
    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('job_analysis', () => ({
                fetched: @entangle('fetched'),
                fetching: @entangle('fetching'),
                fetch() {
                    this.fetching = true;
                    @this.fetch();
                },
            }));

            Alpine.data('archetype_article', () => ({
                article: false,
                toggleArticle() {
                    this.article = !this.article;
                }
            }));
        });
    </script>
@endsection
