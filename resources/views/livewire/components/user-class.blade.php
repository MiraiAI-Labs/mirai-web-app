<div class="relative overflow-hidden rounded-lg flex flex-col shadow bg-base-100 p-2 gap-1 {{ $class ?? '' }}">
    <a id="toggle-archetype-article" class="fa-solid fa-circle-question absolute top-2 right-3 text-xl text-white hover:text-grey cursor-pointer" @click="toggleArticle"></a>
    <p class="text-md text-center">Kelas Anda adalah</p>
    <h1 class="text-4xl font-bold !bg-clip-text text-transparent class-gradient text-center" :class="theme == 'dark' ? 'dark' : 'light'">{{ auth()->user()->userStatistic->archetype->name }}</h1>
    <img src="{{ asset(auth()->user()->userStatistic->archetype->image) }}" alt="" class="my-6 mx-auto rounded-full w-1/2 border-white border-4">
    <p class="text-xl text-center font-semibold">Level {{ auth()->user()->userStatistic->level }}</p>
    <progress class="progress w-56 mx-auto [&::-webkit-progress-value]:bg-[#CF8300] [&::-moz-progress-bar]:bg-[#CF8300]" value="{{ auth()->user()->userStatistic->percentage_to_next_level }}" max="100"></progress>
    <p class="mx-auto">{{ auth()->user()->userStatistic->current_exp_on_current_level }}/{{ auth()->user()->userStatistic->exp_to_next_level }} XP</p>
</div>