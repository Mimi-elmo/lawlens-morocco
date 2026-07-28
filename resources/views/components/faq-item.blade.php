@props(['key' => '', 'question' => ''])

<div x-data="{ open: false }" class="bg-white rounded-xl border border-border overflow-hidden">
    <button @click="open = !open" class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-secondary-50 transition-colors" :aria-expanded="open">
        <span class="font-medium text-secondary-900 pr-4">{{ $question }}</span>
        <x-icon name="chevron-down" class="size-5 text-secondary-400 flex-shrink-0 transition-transform duration-200" ::class="open && 'rotate-180'" />
    </button>
    <div x-show="open" x-collapse.duration.200ms>
        <div class="px-6 pb-4 text-sm text-secondary-600 leading-relaxed">
            {{ $slot }}
        </div>
    </div>
</div>
