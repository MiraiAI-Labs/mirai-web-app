<section x-cloak x-data="quiz" x-show="loaded">
    <div class="flex justify-between items-center">
        <div>
            <span class="text-lg md:text-xl font-semibold" x-text="questionProgress()"></span>
        </div>
        <div class="grid auto-cols-max grid-flow-col gap-5 text-center">
            <div class="flex flex-col text-sm" x-show="time().days > 0">
              <span class="countdown font-mono text-xl md:text-3xl">
                <span x-bind:style="{ '--value': time().days }"></span>
              </span>
              days
            </div>
            <div class="flex flex-col text-sm" x-show="time().hours > 0">
              <span class="countdown font-mono text-xl md:text-3xl">
                <span x-bind:style="{ '--value': time().hours }"></span>
              </span>
              hours
            </div>
            <div class="flex flex-col text-sm">
              <span class="countdown font-mono text-xl md:text-3xl">
                <span x-bind:style="{ '--value': time().minutes }"></span>
              </span>
              min
            </div>
            <div class="flex flex-col text-sm">
              <span class="countdown font-mono text-xl md:text-3xl">
                <span x-bind:style="{ '--value': time().seconds }"></span>
              </span>
              sec
            </div>
        </div>
    </div>

    <div class="mt-4">
        @foreach($questions as $number => $question)
            <div x-show="currentQuestion === {{ $number }}">
                @php
                    $salt = base64_decode(substr(env('APP_KEY'), 7));
                    $hashedAnswer = md5($question['answer'] . $salt);
                @endphp
                <livewire:components.quiz-question :question="$question['question']" :options="$question['options']" :answer="$hashedAnswer" :number="$number" wire:key="question-{{ $number }}" />
            </div>
        @endforeach
    </div>
</section>

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