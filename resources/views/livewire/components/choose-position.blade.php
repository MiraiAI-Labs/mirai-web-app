<div class="w-full md:w-4/5" x-data="{
            selected: @entangle('selectedPosition'),
            text: @entangle('textPosition'),
            choose(target) {
                this.selected = target.getAttribute('value');
                this.text = target.innerText;
                @this.set('selectedPosition', this.selected);
                @this.set('textPosition', this.text);
            },
            pick(id, name) {
                this.selected = id;
                this.text = name;
                @this.set('selectedPosition', this.selected);
                @this.set('textPosition', this.text);
            }
        }">
    <div class="dropdown w-full">
        <label class="input input-bordered flex items-center gap-2">
            <input type="text" class="grow w-full" placeholder="Pilih posisi" x-bind:value="text" wire:keyup="search($event.target.value)"/>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70">
                <path
                fill-rule="evenodd"
                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                clip-rule="evenodd" />
            </svg>
        </label>
        <input type="hidden" name="selected" x-bind:value="selected" wire:model="selectedPosition">
        @if($choosablePositions)
            <ul
            tabindex="0"
            class="dropdown-content dropdown-open menu p-2 shadow bg-base-100 rounded-box w-full max-h-60 overflow-y-auto flex flex-row z-50"
            >
                @if($showResetPosition)
                    <li class="w-full">
                        <span value="0" x-on:click="choose($event.target)">
                            Pilih posisi
                        </span>
                    </li>
                @endif

                @foreach($choosablePositions as $position)
                    <li class="w-full">
                        <span value="{{ $position->id }}" x-on:click="choose($event.target)">
                            {{ $position->name }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @if ($showRecommendations && $recommendations)
        <div class="mt-8 w-full gap-6 flex flex-wrap justify-center">
            @foreach($recommendations as $recommendation)
                <button class="btn btn-neutral normal-case" x-on:click="pick({{ $recommendation->id }}, '{{ $recommendation->name }}')">
                    {{ $recommendation->name }}
                </button>
            @endforeach
        </div>
    @endif
</div>