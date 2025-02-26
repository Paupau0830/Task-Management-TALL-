@props([
'href' => '#', // Default link
'color' => 'bg-gradient-fuchsia', // Default color
'size' => 'text-xs', // Default size
])

<a {{ $attributes->merge(['class' => "inline-block px-8 py-2 m-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft $color shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 $size"]) }} href="{{ $href }}">
    {{ $slot }}
</a>