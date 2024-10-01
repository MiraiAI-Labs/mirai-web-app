@section('title')
    Training Arena
@endsection

<div id="quiz-container" class="drawer-content-container" x-data="quiz">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Training Arena</h2>
    
    <section id="quizzesList" class="mt-4 grid grid-cols-3 gap-6" x-show="!loaded">
        <div class="shadow rounded-[0.875rem] min-h-80 p-0.5 bg-gradient-to-r from-[#FFE500] to-[#FF9000]">
            <div class="rounded-xl bg-base-100 w-full h-full p-8 flex justify-center items-center flex-col">
                <img src="{{ asset("images/timer-pause.png") }}" alt="">
                <h1 class="text-black dark:text-white text-3xl font-bold my-2 text-center">Flash Quiz</h1>
                <h2 class="text-black dark:text-white text-sm font-light mb-4 text-center">Hone your dexterity and concept understanding here!</h2>
                <button class="btn btn-lg btn-orange-gradient normal-case text-black" x-on:click="start()" x-show="!loading && !loaded">Enter Arena</button>
                <span class="loading loading-spinner w-16" x-show="loading && !loaded"></span>
            </div>
        </div>

        <div class="shadow rounded-[0.875rem] min-h-80 p-0.5 bg-gradient-to-r from-[#FFE500] to-[#FF9000]">
            <div class="rounded-xl bg-base-100 w-full h-full p-8 flex justify-center items-center flex-col">
                <img src="{{ asset("images/lamp-on.png") }}" alt="">
                <h1 class="text-black dark:text-white text-3xl font-bold my-2 text-center">Upskill Sets</h1>
                <h2 class="text-black dark:text-white text-sm font-light mb-4 text-center">Ain’t no way you’re getting hired without grinding first, do you?</h2>
                <button class="btn btn-lg btn-orange-gradient normal-case text-black" x-on:click="$wire.dispatch('start-upskill')">Enter Arena</button>
            </div>
        </div>

        <div class="shadow rounded-[0.875rem] min-h-80 p-0.5 bg-gradient-to-r from-[#FFE500] to-[#FF9000]">
            <div class="rounded-xl bg-base-100 w-full h-full p-8 flex justify-center items-center flex-col">
                <img src="{{ asset("images/user-octagon.png") }}" alt="">
                <h1 class="text-black dark:text-white text-3xl font-bold my-2 text-center">Find Your Archetype</h1>
                <h2 class="text-black dark:text-white text-sm font-light mb-4 text-center">Wondering what your archetype is? Find them here!</h2>
                <button class="btn btn-lg btn-orange-gradient normal-case text-black" x-on:click="$wire.dispatch('start-archetype')">Enter Arena</button>
            </div>
        </div>
    </section>

    <livewire:components.flash-quiz />

    <livewire:components.upskill-quiz />

    <livewire:components.archetype-quiz />
</div>

@section('scripts')
    <script>
        // livewire on load
        document.addEventListener('livewire:init', function () {
            Livewire.on('start-upskill', () => {
                document.getElementById('quizzesList').classList.add('hidden');
            });

            Livewire.on('start-archetype', () => {
                document.getElementById('quizzesList').classList.add('hidden');
            });

            Livewire.on('refresh-quiz', () => {
                location.reload();
            });
        });
    </script>
@endsection
