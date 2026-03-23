@props(['name', 'show' => false])

@if ($show)
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
@endif
