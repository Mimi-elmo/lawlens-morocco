@props(['name' => '', 'maxWidth' => 'md', 'show' => false])

@php
    $maxWidths = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ];
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    x-on:close.stop="show = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-10 text-center">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-secondary-900/50 backdrop-blur-sm"
            @click="show = false"
        ></div>

        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-surface rounded-xl shadow-modal border border-border w-full {{ $maxWidths[$maxWidth] ?? $maxWidths['md'] }} text-left"
        >
            <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                <h3 class="text-lg font-semibold text-secondary-900">{{ $title ?? 'Modal' }}</h3>
                <button @click="show = false" class="text-secondary-400 hover:text-secondary-600 transition-colors">
                    <x-icon name="xmark" class="size-5" />
                </button>
            </div>
            <div class="px-6 py-4">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="px-6 py-4 border-t border-border bg-secondary-50/50 rounded-b-xl flex justify-end gap-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
