@props(['name', 'label' => null, 'type' => 'text', 'value' => null, 'placeholder' => null])

<div class="form-group mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <input
        {{ $attributes->merge([
            'type' => $type,
            'name' => $name,
            'id' => $name,
            'value' => old($name, $value),
            'placeholder' => $placeholder,
            'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
        ]) }}
    >

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
