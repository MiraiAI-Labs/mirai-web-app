<div class="relative overflow-hidden rounded-lg flex flex-col justify-evenly shadow bg-base-100 p-2 gap-1 {{ $class ?? '' }}">
    @if($inHome)
        <a id="toggle-archetype-article" class="fa-solid fa-circle-question absolute top-2 right-3 text-xl text-black dark:text-white hover:text-grey cursor-pointer" @click="toggleArticle"></a>
    @endif
    <p class="text-md text-center">Kelas Anda adalah</p>
    <h1 class="text-4xl font-bold !bg-clip-text text-transparent class-gradient text-center" :class="theme == 'dark' ? 'dark' : 'light'">{{ auth()->user()->userStatistic->archetype->name }}</h1>
    <img src="{{ asset(auth()->user()->userStatistic->archetype->image) }}" alt="" class="rounded-full mx-auto w-2/6 border-white border-4">
    @if($inHome)
        <p class="text-xl text-center font-semibold">Level {{ auth()->user()->userStatistic->level }}</p>
        <progress class="progress w-56 mx-auto [&::-webkit-progress-value]:bg-[#CF8300] [&::-moz-progress-bar]:bg-[#CF8300]" value="{{ auth()->user()->userStatistic->percentage_to_next_level }}" max="100"></progress>
        <p class="mx-auto">{{ auth()->user()->userStatistic->current_exp_on_current_level }}/{{ auth()->user()->userStatistic->exp_to_next_level }} XP</p>
    @endif
    @if(!$inHome)
        <button class="btn btn-lg btn-orange-gradient normal-case text-black mt-6" x-on:click="Livewire.dispatch('refresh-quiz')">Ok</button>
    @endif
</div>