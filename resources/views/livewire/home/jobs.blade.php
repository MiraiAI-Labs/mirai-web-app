@section('title')
    Job Vacancies
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Job Vacancies</h2>
    <section class="mt-4" x-data="jobs">
        <div class="bg-base-100 rounded-xl min-h-80 p-4 flex">
            <div class="overflow-y-auto w-full" x-show="!selected">
                <ul tabindex="0" class="bg-base-100 rounded-box z-[1] grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($jobs as $job)
                        <div class="shadow btn w-full text-left rounded-xl h-52 flex flex-col items-center" style="justify-content: left;" x-on:click="changeJob('{{ $job["id"] }}')">
                            <p class="text-xl font-bold mt-auto text-center">{{ $job["title"] }}</p>
                            <p class="text-md font-light">{{ $job["company"] }}</p>
                            <p class="text-md font-light">{{ $job["location"] }}</p>
                            <p class="text-sm font-light mb-auto">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($job["date_posted"]))->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </ul>
            </div>
            <div class="overflow-y-auto w-full p-4 relative" x-show="current_job && selected">
                <button class="btn btn-circle absolute top-0 right-0" x-on:click="selected = false">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="py-2 text-2xl font-bold">{{ $title }}</h2>
                <p class="py-2"><i class="fa-solid fa-calendar-days"></i> {{ ucwords($job_type) }}</p>
                <p class="py-2"><i class="fa-solid fa-building"></i> <a href="{{ $company_url }}">{{ $company }}</a></p>
                <p class="py-2"><i class="fa-solid fa-location-dot"></i> {{ $location }}</p>
                <p class="py-2"><i class="fa-solid fa-clock"></i> Posted {{ \Carbon\Carbon::createFromTimeStamp(strtotime($date_posted))->diffForHumans() }}</p>
                <p class="py-2">{{ $salary }}</p>
                <p class="py-2"><span class="font-bold">Description:</span> </p>
                <div class="py-2">{{ Illuminate\Mail\Markdown::parse($description ?? '') }}</div>

                <a class="btn btn-block btn-neutral mt-6" href="{{ $url }}">Apply</a>
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
                selected: false,
                changeJob(jobId) {
                    this.selected = true;
                    @this.changeJob(jobId);
                }
            }));
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
