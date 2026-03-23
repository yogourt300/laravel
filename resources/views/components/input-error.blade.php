@props(['messages'])

@if ($messages)
    <div {{ $attributes }}>
        @foreach ((array) $messages as $message)
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif
