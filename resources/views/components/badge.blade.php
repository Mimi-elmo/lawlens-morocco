@props(['variant' => 'pending'])

@php
    $variants = [
        'success' => 'bg-success/10 text-success border-success/20',
        'warning' => 'bg-warning/10 text-warning border-warning/20',
        'danger' => 'bg-danger/10 text-danger border-danger/20',
        'pending' => 'bg-secondary-100 text-secondary-600 border-secondary-200',
        'info' => 'bg-info/10 text-info border-info/20',
        'primary' => 'bg-primary-100 text-primary-700 border-primary-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full border ' . ($variants[$variant] ?? $variants['pending'])]) }}>
    {{ $slot }}
</span>
