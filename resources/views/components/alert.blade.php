@props(['type' => 'info', 'message' => null, 'dismissible' => true])

@php
    $types = [
        'success' => ['bg-success/10 border-success/20 text-success', 'check'],
        'warning' => ['bg-warning/10 border-warning/20 text-warning', 'exclamation'],
        'danger' => ['bg-danger/10 border-danger/20 text-danger', 'xmark'],
        'info' => ['bg-info/10 border-info/20 text-info', 'info'],
    ];

    $alertClass = $types[$type][0] ?? $types['info'][0];
    $icon = $types[$type][1] ?? $types['info'][1];
@endphp

@if ($message || $slot->isNotEmpty())
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition:leave="ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        role="alert"
        {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 rounded-lg border mb-4 ' . $alertClass]) }}
    >
        <x-icon :name="$icon" class="size-5 mt-0.5 shrink-0" />
        <div class="flex-1 text-sm">
            {{ $message ?? $slot }}
        </div>
        @if ($dismissible)
            <button @click="show = false" class="shrink-0 opacity-60 hover:opacity-100 transition-opacity">
                <x-icon name="xmark" class="size-4" />
            </button>
        @endif
    </div>
@endif
