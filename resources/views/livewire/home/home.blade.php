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

        <section class="mt-4" x-data="job_analysis" wire:poll="pollFetched">
            <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center" x-show="!fetched">
                <button class="btn btn-lg btn-neutral" x-show="!fetched && !fetching" x-on:click="fetch()">Fetch Analysis</button>
                <span class="loading loading-spinner w-16" x-show="fetching"></span>
            </div>

            @if($this->analysis_json)

                <div x-show="currentChart == 0 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Wordcloud</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.wordcloud :data="$analysis_json['wordcloud_data']" wire:key="wordcloud_data" />
                    </div>
                </div>

                <div x-show="currentChart == 1 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Top 10 Locations</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.bar :data="$analysis_json['top10_job_locs']" wire:key="top10_job_locs" />
                    </div>
                </div>

                <div x-show="currentChart == 2 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Top 10 Most Similar Job Titles</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.bar :data="$analysis_json['top_job_titles']" wire:key="top_job_titles" :isVertical="false"/>
                    </div>
                </div>

                <div x-show="currentChart == 3 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Top 10 Industries With Most Jobs</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.bar :data="$analysis_json['top10_industries_with_most_jobs']" wire:key="top10_industries_with_most_jobs" :isVertical="false"/>
                    </div>
                </div>

                <div x-show="currentChart == 4 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">10 Most Mentioned Tech Stacks in Job Descriptions</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.bar :data="array_slice($analysis_json['most_mentioned_skills_and_techstacks'], 0, 10)" wire:key="most_mentioned_skills_and_techstacks" :isVertical="false"/>
                    </div>
                </div>

                <div x-show="currentChart == 5 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Top 10 Remote Job Titles (Sorted by Frequency)</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.bar :data="$analysis_json['top10_remote_jobs']" wire:key="top10_remote_jobs" :isVertical="false"/>
                    </div>
                </div>

                <div x-show="currentChart == 6 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Top 10 Non-Remote Job Titles (Sorted by Frequency)</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.bar :data="$analysis_json['top10_non_remote_jobs']" wire:key="top10_non_remote_jobs" :isVertical="false"/>
                    </div>
                </div>

                <div x-show="currentChart == 7 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Job Posting Trends Over Time</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.line :data="$analysis_json['job_post_trend']" wire:key="job_post_trend" />
                    </div>
                </div>

                <div x-show="currentChart == 8 && fetched" class="bg-base-100 rounded-xl flex justify-center items-center h-[50svh] p-8 flex-col items-center">
                    <h2 class="text-xl font-bold mb-4">Top Tech Stacks Trends Over Time</h2>
                    <div class="w-full h-full flex justify-center">
                        <livewire:components.line :data="$analysis_json['tech_stacks_overtime']" wire:key="tech_stacks_overtime" :multiple="true"/>
                    </div>
                </div>
            @endif
            
            <div class="flex">
                <button class="btn btn-md btn-neutral normal-case mt-6" x-show="fetched" x-on:click="prevChart()"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="ml-auto btn btn-md btn-neutral normal-case mt-6" x-show="fetched" x-on:click="nextChart()"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </section>
    @endif
</div>

@section('scripts')
    @vite('resources/js/chart.js')
    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('job_analysis', () => ({
                fetched: @entangle('fetched'),
                fetching: @entangle('fetching'),
                currentChart: 0,
                chartCount: 9,
                fetch() {
                    this.fetching = true;
                    @this.fetch();
                },
                nextChart() {
                    this.currentChart++;

                    if(this.currentChart > this.chartCount - 1)
                    {
                        this.currentChart = 0;
                    }
                },
                prevChart() {
                    this.currentChart--;

                    if(this.currentChart < 0)
                    {
                        this.currentChart = this.chartCount - 1;
                    }
                },
            }));
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
