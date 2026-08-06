@props(['padding' => true, 'header' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-surface rounded-xl border border-border shadow-card']) }}>
    @if ($header)
        <div class="px-6 py-4 border-b border-border">
            {{ $header }}
        </div>
    @endif
    @if ($padding)
        <div class="px-6 py-4">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
    @if ($footer)
        <div class="px-6 py-4 border-t border-border bg-secondary-50/50 rounded-b-xl">
            {{ $footer }}
        </div>
    @endif
</div>
