@section('title')
    Quiz Exercise
@endsection

<div id="quiz-container" class="drawer-content-container" x-data="quiz">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Quiz Exercise</h2>
    <section class="flex justify-between items-center" x-show="loaded">
        <div>
            <span class="text-lg font-semibold" x-text="questionProgress()"></span>
        </div>
        <div class="grid auto-cols-max grid-flow-col gap-5 text-center">
            <div class="flex flex-col text-sm" x-show="time().days > 0">
              <span class="countdown font-mono text-xl">
                <span x-bind:style="{ '--value': time().days }"></span>
              </span>
              days
            </div>
            <div class="flex flex-col text-sm" x-show="time().hours > 0">
              <span class="countdown font-mono text-xl">
                <span x-bind:style="{ '--value': time().hours }"></span>
              </span>
              hours
            </div>
            <div class="flex flex-col text-sm">
              <span class="countdown font-mono text-xl">
                <span x-bind:style="{ '--value': time().minutes }"></span>
              </span>
              min
            </div>
            <div class="flex flex-col text-sm">
              <span class="countdown font-mono text-xl">
                <span x-bind:style="{ '--value': time().seconds }"></span>
              </span>
              sec
            </div>
        </div>
    </section>
    <section class="mt-4" x-show="!loaded">
        <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center">
            <button class="btn btn-lg btn-neutral" x-on:click="start()" x-show="!loading && !loaded">Mulai Quiz</button>
            <span class="loading loading-spinner w-16" x-show="loading && !loaded"></span>
        </div>
    </section>

    <section class="mt-4" x-show="loaded">
        @foreach($questions as $number => $question)
            <div x-show="currentQuestion === {{ $number }}">
                @php
                    $salt = base64_decode(substr(env('APP_KEY'), 7));
                    $hashedAnswer = md5($question['answer'] . $salt);
                @endphp
                <livewire:components.quiz-question :question="$question['question']" :options="$question['options']" :answer="$hashedAnswer" :number="$number" wire:key="question-{{ $number }}" />
            </div>
        @endforeach
    </section>
</div>

@section('scripts')
    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('quiz', () => ({
                maxQuestions: 0,
                init() {
                    let t = this;
                    document.addEventListener('questions-loaded', (e) => {
                        const expiry = new Date().getTime() + 90 * 1000;
                        t.startTimer(expiry);
                        
                        this.maxQuestions = @this.get('questions').length;
                    });

                    document.addEventListener('quizCompleted', (e) => {
                        if(this.interval)
                            clearInterval(this.interval);
                    });
                },
                loading: @entangle('loading'),
                loaded: @entangle('loaded'),
                currentQuestion: @entangle('currentQuestion'),
                start() {
                    this.loading = true;
                    @this.start();
                },
                questionProgress() {
                    return `${this.currentQuestion + 1} / ${this.maxQuestions} Pertanyaan`;
                },
                expiry: null,
                remaining: null,
                interval: null,
                startTimer(expiry) {
                    this.expiry = expiry;

                    this.setRemaining()
                    
                    this.interval = setInterval(() => {
                        this.setRemaining();
                    }, 1000);

                    console.log('startTimer');
                },
                setRemaining() {
                    const diff = this.expiry - new Date().getTime();

                    if(diff <= 0) {
                        @this.timeout();
                        clearInterval(this.interval);
                        this.expiry = null;
                        this.remaining = null;
                        return;
                    }

                    this.remaining =  parseInt(diff / 1000);
                },
                days() {
                    return {
                        value:this.remaining / 86400,
                        remaining:this.remaining % 86400
                    };
                },
                hours() {
                    return {
                        value:this.days().remaining / 3600,
                        remaining:this.days().remaining % 3600
                    };
                },
                minutes() {
                    return {
                        value:this.hours().remaining / 60,
                        remaining:this.hours().remaining % 60
                    };
                },
                seconds() {
                    return {
                        value:this.minutes().remaining,
                    };
                },
                format(value) {
                    return ("0" + parseInt(value)).slice(-2)
                },
                time(){
                    return {
                        days:this.format(this.days().value),
                        hours:this.format(this.hours().value),
                        minutes:this.format(this.minutes().value),
                        seconds:this.format(this.seconds().value),
                    }
                },
            }));
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
