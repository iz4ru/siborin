@props(['active' => false])

@php
$classes = $active
            ? 'flex items-center p-2 text-[#0077C3] rounded-lg dark:text-[#1A85C9] bg-gray-100 group'
            : 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
