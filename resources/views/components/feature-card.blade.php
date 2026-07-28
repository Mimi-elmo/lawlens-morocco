@props(['icon' => 'sparkles', 'title' => '', 'description' => '', 'badge' => ''])

<div class="group relative bg-white rounded-2xl border border-border p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-500/5 to-secondary-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="relative z-10">
        <div class="size-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <x-icon :name="$icon" class="size-6" />
        </div>
        @if ($badge)
            <span class="inline-block px-2 py-0.5 rounded-full bg-primary-50 text-primary-600 text-xs font-medium mb-3">{{ $badge }}</span>
        @endif
        <h3 class="text-lg font-semibold text-secondary-900 mb-2">{{ $title }}</h3>
        <p class="text-sm text-secondary-500 leading-relaxed">{{ $description }}</p>
    </div>
</div>
