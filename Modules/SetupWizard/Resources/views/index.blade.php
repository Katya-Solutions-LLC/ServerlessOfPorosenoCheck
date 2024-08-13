<x-guest-layout>
    <x-slot name="styles">
        <link rel="stylesheet" href="{{ mix('modules/setupwizard/style.css') }}" defer>
        </script>
    </x-slot>
    <div data-render="setup-app">
        <setup-wizard></setup-wizard>
    </div>
    <x-slot name="scripts">
        <script src="{{ mix('modules/setupwizard/script.js') }}" defer></script>
    </x-slot>
</x-guest-layout>
