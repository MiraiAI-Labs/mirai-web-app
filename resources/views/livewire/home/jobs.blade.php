@section('title')
    Job Vacancies
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Job Vacancies</h2>
    <section class="mt-4" x-data="jobs">
        <div class="bg-base-100 rounded-xl min-h-80 p-4 max-h-[300px] h-[300px] flex">
            <div class="overflow-y-auto w-full">
                <ul tabindex="0" class="bg-base-100 rounded-box z-[1]">
                    @foreach($jobs as $job)
                        <li class="btn w-full rounded-none text-left !flex !items-center" style="justify-content: left;" x-on:click="changeJob('{{ $job["id"] }}')">{{ $job["title"] }} - {{ $job["company"] }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="overflow-y-auto w-full p-4" x-show="current_job">
                <h2 class="py-2 text-xl font-bold">{{ $title }}</h2>
                <p class="py-2"><span class="font-bold">Date Posted:</span> {{ date("j F Y",strtotime($date_posted)) }} ({{ \Carbon\Carbon::createFromTimeStamp(strtotime($date_posted))->diffForHumans() }})</p>
                <p class="py-2"><span class="font-bold">Company:</span> {{ $company }}</p>
                <p class="py-2"><span class="font-bold">Location:</span> {{ $location }} - {{ $job_type }}</p>
                <p class="py-2"><span class="font-bold">Description:</span> </p>
                <div class="py-2">{{ Illuminate\Mail\Markdown::parse($description ?? '') }}</div>
            </div>
        </div>
    </section>
</div>

@section('scripts')
    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('jobs', () => ({
                current_job: @entangle('current_job'),
                title: @entangle('title'),
                date_posted: @entangle('date_posted'),
                company: @entangle('company'),
                location: @entangle('location'),
                job_type: @entangle('job_type'),
                description: @entangle('description'),
                changeJob(jobId) {
                    @this.changeJob(jobId);
                }
            }));
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
