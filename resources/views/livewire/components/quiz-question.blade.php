<div class="shadow bg-base-100 rounded-xl flex justify-center items-center min-h-80 p-12 flex-col items-center" x-data="{ chosen: @entangle('chosen') }">
    <header class="text-2xl font-semibold mb-6">{{ $question ?? '' }}</header>
    <main class="mt-4 w-full flex flex-col">
        <div class="form-control gap-6 grid grid-cols-1 md:grid-cols-2">
            @foreach($options as $no => $option)
                <label class="label cursor-pointer !h-auto p-4 rounded-xl input input-bordered input-checkbox {{ $labelStyle[$no] }} gap-6">
                    <span class="label-text p-2 text-lg font-light">{{ $option ?? '' }}</span>
                    <input type="radio" name="answer-{{ $no }}" class="radio {{ $radioStyle[$no] }}" x-bind:disabled="chosen" wire:model.change="chosenOption" value="{{ $no }}" />
                </label>
            @endforeach
        </div>
        <button class="ml-auto btn btn-md btn-neutral normal-case mt-6" x-show="chosen" x-on:click="@this.dispatch('nextQuestion')"><i class="fa-solid fa-arrow-right"></i></button>
    </main>
</div>