@props(['ref'])

<x-base-modal ref="{{ $ref }}" class="max-w-lg">
    {{ $slot }}
</x-base-modal>