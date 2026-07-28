@props(['icon' => 'folder', 'title' => '', 'message' => '', 'action' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-4 text-center']) }}>
    <div class="size-16 rounded-full bg-secondary-100 flex items-center justify-center mb-4">
        <x-icon :name="$icon" class="size-8 text-secondary-400" />
    </div>
    @if ($title)
        <h3 class="text-lg font-semibold text-secondary-900 mb-1">{{ $title }}</h3>
    @endif
    @if ($message)
        <p class="text-sm text-secondary-500 max-w-sm mb-6">{{ $message }}</p>
    @endif
    @if ($action)
        {{ $action }}
    @endif
    {{ $slot }}
</div>
