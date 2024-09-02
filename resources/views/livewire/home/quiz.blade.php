@section('title')
    Quiz Exercise
@endsection

<div class="drawer-content-container" x-data="quiz">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Quiz Exercise</h2>
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
                loading: @entangle('loading'),
                loaded: @entangle('loaded'),
                currentQuestion: @entangle('currentQuestion'),
                start() {
                    this.loading = true;
                    @this.start();
                },
            }));
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
