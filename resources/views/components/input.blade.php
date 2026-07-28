@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'helper' => null,
    'error' => null,
    'required' => false,
])

@php
    $hasError = $error || $errors->has($name);
    $errorMessage = $error ?: ($errors->first($name) ?? '');
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:model') }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-secondary-700 mb-1">
            {{ $label }}
            @if ($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->wire('model') }}
        @class([
            'block w-full rounded-lg border px-3 py-2 text-sm shadow-sm transition-colors',
            'placeholder:text-secondary-400 focus:outline-none focus:ring-2 focus:ring-offset-0',
            'border-border text-secondary-900 focus:border-primary-500 focus:ring-primary-500/20' => !$hasError,
            'border-danger text-danger focus:border-danger focus:ring-danger/20' => $hasError,
        ])
    >
    @if ($helper && !$hasError)
        <p class="mt-1 text-xs text-secondary-500">{{ $helper }}</p>
    @endif
    @if ($hasError)
        <p class="mt-1 text-xs text-danger">{{ $errorMessage }}</p>
    @endif
</div>
