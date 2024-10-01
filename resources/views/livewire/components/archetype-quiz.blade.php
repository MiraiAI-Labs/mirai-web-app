<section x-data="archetype" class="flex">
    <style>
        /* Show yellow background and tick mark when selected */
        input[type="radio"]:checked {
            background: linear-gradient(90deg, rgba(255, 229, 0, 1) 0%, rgba(255, 144, 0, 1) 100%);
            /* remove the transparent gap of radio button */
        }

        /* Add the tick mark */
        /* input[type="radio"]:checked::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        } */
    </style>

    <div class="flex flex-col-reverse md:flex-row gap-6 text-black dark:text-white pop-anim w-full" x-cloak x-show="show">
        <div class="w-full md:w-3/4">
            @foreach($questions as $question)
                <div class="rounded-xl shadow bg-base-100 p-8" x-cloak x-show="currentQuestion === {{ $loop->index }}">
                    <div class="form-control gap-4">
                        <h1 class="text-3xl font-bold">Soal {{ $loop->index + 1 }}</h1>
                        <p class="text-lg">{{ $question['question'] }}</p>
                        <div class="flex">
                            <span class="text-xs">Sangat tidak setuju</span>
                            <span class="text-xs ml-auto">Sangat setuju</span>
                        </div>
                        <div class="flex justify-between">
                            @for($i = -5; $i <= 5; $i++)
                                <input type="radio" name="archetype-question-{{ $loop->index + 1 }}" class="radio archetype-radio relative" value="{{$i}}" wire:model="answers.{{ $loop->index }}" />
                            @endfor
                        </div>
                    </div>
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
                    <button class="btn rounded-xl" x-bind:class="currentQuestion === {{ $i }} ? 'btn-orange-gradient text-black' : ((answers[{{$i}}] ?? null) !== null && currentQuestion !== {{$i}} ? 'btn-blue-gradient text-white' : 'bg-base-100 text-black dark:text-white')" x-on:click="currentQuestion = {{ $i }}">{{ $i + 1 }}</button>
                @endfor
            </div>

            <button class="btn w-full btn-orange-gradient text-black mt-4" wire:click="submit">
                <span wire:loading.remove wire:target="submit">
                    <i class="fa-solid fa-paper-plane"></i> Submit
                </span>

                <span class="loading loading-spinner" wire:loading wire:target="submit"></span>
            </button>

            @if (app()->environment('local'))
                <button class="btn w-full btn-orange-gradient text-black mt-4" wire:click="randomizeAnswers">
                    <span wire:loading.remove wire:target="randomizeAnswers">
                        Randomize Answers
                    </span>
    
                    <span class="loading loading-spinner" wire:loading wire:target="randomizeAnswers"></span>
                </button>
            @endif

        </div>
    </div>

    <div x-cloak x-show="showResult" class="w-1/2 mx-auto">
        <livewire:components.UserClass :inHome="false"/>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('archetype', () => ({
                currentQuestion: @entangle('currentQuestion'),
                minQuestions: 0,
                maxQuestions: @entangle('totalQuestions'),
                answers: @entangle('answers'),
                show: false,
                showResult: false,
                init() {
                    let t = this;
                    Livewire.on('start-archetype', () => {
                        t.show = true;
                        t.startTimer();
                        @this.start();
                    });


                    Livewire.on('archetype-quiz-completed', () => {
                        t.show = false;
                        t.showResult = true;
                    });
                },
                startTimer() {
                    let t = this;
                    const expiry = new Date().getTime() + 10 * 60 * 1000;
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