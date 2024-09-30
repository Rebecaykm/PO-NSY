<style>
    .max-width-cell {
    max-width: 8px; /* Establece el ancho máximo deseado */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    /* Agrega reglas de estilo personalizadas aquí */
    .truncate-text {
        max-width: 100px; /* Ajusta la cantidad máxima de caracteres que deseas mostrar */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .name-cell {
        max-width: 150px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
    .description-cell {
        max-width: 200px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
    .assigned {
    padding: 0.5rem 1rem;
    font-weight: 600;
    color: #047857; /* text-green-700 */
    background-color: #d1fae5; /* bg-green-100 */
    border-radius: 9999px; /* rounded-full */
    display: inline-block; /* to ensure correct padding and background application */
    }

    .ni-assigned {
        padding: 0.5rem 1rem; /* py-2 px-4 */
        font-weight: 600; /* font-semibold */
        color: #4B5563; /* text-gray-700 */
        background-color: #F3F4F6; /* bg-gray-100 */
        border-radius: 9999px; /* rounded-full */
        display: inline-block; /* to ensure correct padding and background application */
    }

    .dark .ni-assigned {
        color: #F3F4F6; /* dark:text-gray-100 */
        background-color: #374151; /* dark:bg-gray-700 */
    }

    .not-assigned {
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: #b91c1c; /* text-red-700 */
        background-color: #fee2e2; /* bg-red-100 */
        border-radius: 9999px; /* rounded-full */
        display: inline-block; /* to ensure correct padding and background application */
    }
</style>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    {{-- <html x-data="data()" data-bs-theme="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="{{ asset('js/init-alpine.js') }}" defer></script>

        <!-- Charts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
        <script src="{{ asset('js/charts-lines.js') }}" defer></script>
        <script src="{{ asset('js/charts-pie.js') }}" defer></script>
        <script src="{{ asset('js/charts-bars.js') }}" defer></script>
        <script src="{{ asset('js/production-records.js') }}" defer></script>
        <script src="{{ asset('js/production-plan.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Agrega estos enlaces en tu plantilla si no están ya incluidos -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link  href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

        @livewireStyles

    </head>
    <body>
        <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
            @include('layouts.menu')
            @include('layouts.mobile-menu')
            <div class="flex flex-col flex-1 w-full">
                @include('layouts.navigation-dropdown')
                <main class="h-full overflow-y-auto border-green-600">
                    {{ $slot }}
                </main>
            </div>
            @stack('modals')
            @livewireScripts
        </div>
    </body>
</html>
