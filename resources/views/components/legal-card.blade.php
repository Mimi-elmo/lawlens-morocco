@props(['name' => '', 'fullName' => '', 'description' => '', 'type' => '', 'icon' => 'briefcase', 'features' => '[]'])

<div class="group relative bg-white rounded-2xl border border-border p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
    <div class="flex items-start justify-between mb-4">
        <div class="size-12 rounded-xl bg-accent-100 text-accent-600 flex items-center justify-center">
            <x-icon :name="$icon" class="size-6" />
        </div>
        <span class="px-2.5 py-0.5 rounded-full bg-secondary-100 text-secondary-600 text-xs font-medium capitalize">{{ $type }}</span>
    </div>
    <h3 class="text-xl font-bold text-secondary-900 mb-1">{{ $name }}</h3>
    <p class="text-sm text-secondary-500 mb-3">{{ $fullName }}</p>
    <p class="text-sm text-secondary-600 leading-relaxed mb-4">{{ $description }}</p>
    <ul class="space-y-2">
        @foreach (json_decode($features, true) as $feature)
            <li class="flex items-start gap-2 text-sm text-secondary-500">
                <x-icon name="check" class="size-4 text-primary-500 flex-shrink-0 mt-0.5" />
                {{ $feature }}
            </li>
        @endforeach
    </ul>
</div>
