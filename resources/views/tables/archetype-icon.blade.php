@php
    $archetype = App\Models\Archetype::where('id', $value)->first();
@endphp

<div class="flex flex-col items-center items-center gap-2">
    <img src="{{ asset($archetype->image) }}" alt="" class="rounded-full w-16 border-white border-4">
    <h1 class="text-sm font-bold text-center !bg-clip-text text-transparent class-gradient text-center" :class="theme == 'dark' ? 'dark' : 'light'">{{$archetype->name}}</h1>
</div>

