<div class="flex items-start gap-2.5 justify-start" wire:ignore>
    <div class="skeleton flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $attributes['name'] ?? "" }}</span>
        </div>
        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">
            <canvas id="{{ $attributes['id'] }}" width="400" height="400"></canvas>
            {{ $attributes['message'] ?? "" }}
        </p>
    </div>
</div>