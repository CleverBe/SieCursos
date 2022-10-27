<button {{ $attributes->merge(['class' => "btn btn-$color"]) }}>
    {{ $slot }}
    {{ $texto }}
</button>
