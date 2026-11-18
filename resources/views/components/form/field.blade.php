@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'id' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $errorKey = trim(preg_replace('/\[([^\]]*)\]/', '.$1', $name), '.');
    $fieldId = $id ?? 'field-'.str_replace(['.', '_'], '-', $errorKey);
    $error = $errors->first($errorKey);
    $describedBy = trim(implode(' ', array_filter([
        $attributes->get('aria-describedby'),
        $hint ? $fieldId.'-hint' : null,
        $error ? $fieldId.'-error' : null,
    ])));
    $control = $attributes->except('aria-describedby')->class(['site-field-control'])->merge([
        'id' => $fieldId,
        'name' => $name,
        'required' => $required,
        'disabled' => $disabled,
    ]);
    if ($describedBy !== '') {
        $control = $control->merge(['aria-describedby' => $describedBy]);
    }
    if ($error) {
        $control = $control->merge(['aria-invalid' => 'true']);
    }
@endphp

<div class="site-field">
    <label for="{{ $fieldId }}" class="site-field-label">{{ $label }} @if($required)<span class="site-field-required" aria-hidden="true">*</span>@endif</label>
    @if($type === 'select')
        <select {{ $control }}>{{ $slot }}</select>
    @elseif($type === 'textarea')
        <textarea {{ $control }}>{{ old($errorKey, $value) }}</textarea>
    @elseif($type === 'password')
        <div class="site-password-control">
            <input type="password" {{ $control }}>
            <button type="button" data-password-toggle="{{ $fieldId }}" aria-label="إظهار {{ $label }}" aria-pressed="false"><i class="fa-regular fa-eye" aria-hidden="true"></i></button>
        </div>
    @elseif($type === 'file')
        <input type="{{ $type }}" {{ $control }}>
    @else
        <input type="{{ $type }}" value="{{ $disabled ? $value : old($errorKey, $value) }}" {{ $control }}>
    @endif
    @if($hint)<p id="{{ $fieldId }}-hint" class="site-field-hint">{{ $hint }}</p>@endif
    @if($error)<p id="{{ $fieldId }}-error" class="site-field-error">{{ $error }}</p>@endif
</div>
