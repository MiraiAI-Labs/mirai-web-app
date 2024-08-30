<a class="app-card {{ $class ?? '' }} {{ $background ?? '' }}" href="{{ $url ?? '' }}">
    <div class="group relative rounded-[inherit] before:transition-all before:duration-300 card-body overflow-hidden hover:before:top-0 hover:before:right-0 hover:before:rounded-none hover:before:w-full hover:before:h-full before:w-40 before:h-40 before:absolute before:bg-base-100/70 before:backdrop-blur-sm before:-top-20 before:-right-20 before:rounded-[20rem]">
        @if($icon ?? null !== null)
        <i class="{{ $icon }} fa-2x transition-all duration-300 absolute top-4 right-4 group-hover:transform-center-scaled {{ $background ?? null !== null ? $background . ' bg-clip-text text-transparent' : '' }}"></i>
        @endif
        <h2 class="card-title">{{ $title ?? '' }}</h2>
        <p>{{ $subtitle ?? '' }}</p>
    </div>
</a>