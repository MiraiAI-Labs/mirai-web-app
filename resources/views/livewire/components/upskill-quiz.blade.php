<section x-data="upskill" x-cloak x-show="show">
    <div class="w-full h-[50svh] flex" wire:target="start" wire:loading>
        <div class="w-full h-full flex justify-center items-center">
            <div class="loading loading-spinner w-16"></div>
        </div>
    </div>

    <div class="flex flex-col-reverse md:flex-row gap-6 text-black dark:text-white pop-anim" wire:target="start" wire:loading.remove>
        <div class="w-full md:w-1/4 flex flex-col gap-4" x-bind:class="!evaluated ? 'hidden' : ''">
            <div class="rounded-xl shadow bg-base-100 p-8 flex flex-col justify-center items-center gap-4">
                <h2 class="text-xl">Overall Score</h2>
                <p class="text-6xl font-bold">{{ $average }}</p>
            </div>
            <div class="rounded-xl shadow bg-base-100 p-8 flex flex-col justify-center items-center gap-4">
                @foreach($nilaiPerCategory as $category => $nilai)
                    <div class="flex flex-col justify-center items-center">
                        <h2 class="text-sm">{{ $category }}</h2>
                        <p class="text-2xl font-bold">{{ $nilai }}</p>
                    </div>
                @endforeach
            </div>

            <button class="btn w-full btn-orange-gradient !text-black" wire:click="retry" wire:target="retry" wire:loading.attr="disabled">
                <i class="fa-solid fa-repeat"></i>
                    Retry
                </span>

                <span class="loading loading-spinner" wire:loading wire:target="retry"></span>
            </button>

            @if (app()->environment('local'))
                <button class="btn w-full btn-orange-gradient !text-black" wire:click="submit" wire:target="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        Resubmit
                    </span>
    
                    <span class="loading loading-spinner" wire:loading wire:target="submit"></span>
                </button>
            @endif
        </div>
        
        <div class="w-full md:w-3/4 gap-6 flex flex-col">
            @foreach($questions as $question)
                <div class="rounded-xl shadow bg-base-100 p-8" x-cloak x-show="evaluated || currentQuestion === {{ $loop->index }}">
                    <label class="form-control gap-4">
                        <h1 class="text-3xl font-bold">Soal {{ $loop->index + 1 }}</h1>
                        <p class="text-lg">{{ $question['question'] }}</p>
                        <textarea x-bind:disabled="evaluated" class="textarea textarea-bordered h-24" placeholder="Ketik Jawaban Anda Disini" wire:model="answers.{{ $loop->index }}"></textarea>
                        <div x-show="evaluated">
                            <p x-text="feedbacks[{{$loop->index}}]"></p>
                        </div>
                    </label>
                </div>

            @endforeach

            <div class="w-full flex mt-2" x-show="!evaluated">
                <button class="btn bg-base-100 text-black dark:text-white" x-on:click="currentQuestion--" x-cloak x-show="currentQuestion > minQuestions"><i class="fa-solid fa-angle-left"></i></button>
                <button class="btn ml-auto bg-base-100 text-black dark:text-white" x-on:click="currentQuestion++" x-cloak x-show="currentQuestion < (maxQuestions - 1)"><i class="fa-solid fa-angle-right"></i></button>
            </div>
        </div>
        <div class="w-full md:w-1/4" x-bind:class="evaluated ? 'hidden' : ''">
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
                    <button class="btn rounded-xl" x-bind:class="currentQuestion === {{ $i }} ? 'btn-orange-gradient text-black' : ((answers[{{$i}}] ?? null) !== null && currentQuestion !== {{$i}} ? 'btn-blue-gradient text-white' : 'bg-base-100 text-black dark:text-white')" x-on:click="currentQuestion = {{ $i }}">{{ $i + 1 }}</button>
                @endfor
            </div>

            <button class="btn w-full btn-orange-gradient !text-black mt-4" wire:click="submit" wire:target="submit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="submit">
                    <i class="fa-solid fa-paper-plane"></i> Submit
                </span>

                <span class="loading loading-spinner" wire:loading wire:target="submit"></span>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('upskill', () => ({
                currentQuestion: @entangle('currentQuestion'),
                minQuestions: 0,
                maxQuestions: @entangle('totalQuestions'),
                answers: @entangle('answers'),
                feedbacks: @entangle('feedbacks'),
                nilais: @entangle('nilais'),
                average: @entangle('average'),
                evaluated: @entangle('evaluated'),
                show: false,
                init() {
                    let t = this;
                    Livewire.on('start-upskill', () => {
                        t.show = true;
                        t.startTimer();
                        @this.start();
                    });

                    Livewire.on('retry-upskill', () => {
                        t.show = true;
                        t.resetTimer();
                        t.startTimer();
                    });
                },
                startTimer() {
                    let t = this;
                    const expiry = new Date().getTime() + 15 * 60 * 1000;
                    // const expiry = new Date().getTime() + 10 * 1000;
                    let timer = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = expiry - now;
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        t.time = { days, hours, minutes, seconds };

                        // check if time is up
                        if (distance < 0) {
                            clearInterval(timer);
                            @this.forceSubmit();
                        }
                    }, 1000);
                },
                resetTimer() {
                    this.time = {
                        days: 0,
                        hours: 0,
                        minutes: 0,
                        seconds: 0
                    };
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