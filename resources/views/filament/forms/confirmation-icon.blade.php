@php
    $isConfirmed = (bool) $state;
    $icon = $isConfirmed ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle';
    $color = $isConfirmed ? 'success' : 'danger';
@endphp


<div class="flex flex-col items-center">
    <span class="text-sm font-medium text-gray-700">Confirmation</span>
    <x-filament::icon
        :icon="$icon"
        :color="$color"
        class="h-6 w-6"
    />
</div>