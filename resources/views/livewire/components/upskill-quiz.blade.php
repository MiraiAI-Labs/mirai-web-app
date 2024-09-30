<section x-data="upskill" x-cloak x-show="show">
    <div class="flex flex-col-reverse md:flex-row gap-6 text-black dark:text-white pop-anim">
        <div class="w-full md:w-3/4">
            @foreach($questions as $question)
                <div class="rounded-xl shadow bg-base-100 p-8" x-cloak x-show="currentQuestion === {{ $loop->index }}">
                    <label class="form-control gap-4">
                        <h1 class="text-3xl font-bold">Soal {{ $loop->index + 1 }}</h1>
                        <p class="text-lg">{{ $question['question'] }}</p>
                        <textarea class="textarea textarea-bordered h-24" placeholder="Ketik Jawaban Anda Disini" wire:model="answers.{{ $loop->index }}"></textarea>
                    </label>
                </div>

            @endforeach

            <div class="w-full flex mt-2">
                <button class="btn bg-base-100 text-black dark:text-white" x-on:click="currentQuestion--" x-cloak x-show="currentQuestion > minQuestions"><i class="fa-solid fa-angle-left"></i></button>
                <button class="btn ml-auto bg-base-100 text-black dark:text-white" x-on:click="currentQuestion++" x-cloak x-show="currentQuestion < (maxQuestions - 1)"><i class="fa-solid fa-angle-right"></i></button>
            </div>
        </div>
        <div class="w-full md:w-1/4">
            <div class="rounded-xl shadow bg-base-100 p-8 flex flex-col justify-center items-center gap-4">
                <h2 class="text-xl">Sisa Waktu</h2>
                <div class="font-semibold grid auto-cols-max grid-flow-col gap-5 text-center">
                    <div class="flex flex-col text-sm" x-show="time.days > 0">
                      <span class="countdown font-mono text-6xl">
                        <span x-bind:style="{ '--value': time.days }"></span>
                      </span>
                      days
                    </div>
                    <div class="flex flex-col text-sm" x-show="time.hours > 0">
                      <span class="countdown font-mono text-6xl">
                        <span x-bind:style="{ '--value': time.hours }"></span>
                      </span>
                      hours
                    </div>
                    <div class="flex flex-col text-sm">
                      <span class="countdown font-mono text-6xl">
                        <span x-bind:style="{ '--value': time.minutes }"></span>
                      </span>
                      min
                    </div>
                    <div class="flex flex-col text-sm">
                      <span class="countdown font-mono text-6xl">
                        <span x-bind:style="{ '--value': time.seconds }"></span>
                      </span>
                      sec
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-5 gap-1 mt-4">
                @for($i = 0; $i < count($questions); $i++)
                    <button class="btn rounded-xl" x-bind:class="currentQuestion === {{ $i }} ? 'btn-orange-gradient text-black' : 'bg-base-100 text-black dark:text-white'" x-on:click="currentQuestion = {{ $i }}">{{ $i + 1 }}</button>
                @endfor
            </div>

            <button class="btn w-full btn-orange-gradient text-black mt-4" wire:click="submit"><i class="fa-solid fa-paper-plane"></i> Submit</button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('upskill', () => ({
                currentQuestion: @entangle('currentQuestion'),
                minQuestions: 0,
                maxQuestions: @entangle('totalQuestions'),
                show: false,
                init() {
                    let t = this;
                    Livewire.on('start-upskill', () => {
                        t.show = true;
                        t.startTimer();
                        @this.start();
                    });

                },
                startTimer() {
                    let t = this;
                    const expiry = new Date().getTime() + 15 * 60 * 1000;
                    setInterval(() => {
                        const now = new Date().getTime();
                        const distance = expiry - now;
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        t.time = { days, hours, minutes, seconds };
                    }, 1000);
                },
                time: {
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0
                }
            }));
        });
    </script>
</section>