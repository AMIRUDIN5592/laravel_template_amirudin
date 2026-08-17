@props(['variant' => 'primary', 'type' => 'submit'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn btn-' . $variant]) }}>
    {{ $slot }}
</button>
