@props(['name', 'label' => null, 'options' => [], 'value' => null])

<div class="form-group mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        {{ $attributes->merge([
            'name' => $name,
            'id' => $name,
            'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
        ]) }}
    >
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
