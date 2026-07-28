@props(['class' => ''])

<a href="/" {{ $attributes->merge(['class' => 'flex items-center gap-2 ' . $class]) }}>
    <div class="size-8 rounded-lg bg-primary-600 flex items-center justify-center">
        <x-icon name="scale" class="size-5 text-white" />
    </div>
    <span class="text-lg font-bold text-secondary-900">LawLens</span>
</a>
