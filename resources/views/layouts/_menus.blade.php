<style>
    .selected-option {
    opacity: 1.5; /* Ajusta la opacidad según tu preferencia */
    background-color: #e2e8f0;
    }
</style>

<div class="py-4 text-gray-500 dark:text-gray-400">
    <ul class="mt-6">
        @can('Admin.AVM.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Admin.AVM.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Admin.AVM.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Admin.AVM.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Proveedores AVM</span>
            </a>
        </li>
        @endcan
        @can('Admin.IPB.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Admin.IPB.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Admin.IPB.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Admin.IPB.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <span class="ml-4">Compradores IPB</span>
            </a>
        </li>
        @endcan
        @can('Admin.YH100.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Admin.YH100.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Admin.YH100.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Admin.YH100.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <span class="ml-4">YH100</span>
            </a>
        </li>
        @endcan
    {{-- </details>
    @can('Configuration.Department.index')
    <details class="open:bg-white dark:open:bg-white open:ring-1 open:ring-black/5 dark:open:ring-white/10 open:shadow-lg rounded-lg" open>
        <summary class="inline-flex items-center relative px-4 py-3 w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-400" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor"></path>
            </svg>
            <span class="ml-1">Configuraciones</span>
        </summary>
        --}}
        @can('Configuration.Category.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Category.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Category.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Category.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Categorias</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Classification.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Classification.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Classification.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Classification.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Clasificación</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Department.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Department.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Department.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Department.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Departamentos</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Item.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Item.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Item.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Item.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Items</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Item.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.CostCenter.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.CostCenter.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.CostCenter.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Centro de Costos</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Item.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Buyer.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Buyer.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Buyer.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Compradores</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Status.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Status.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Status.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Status.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">{{ __('messages.status') }}</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Supplier.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Supplier.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Supplier.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Supplier.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">{{ __('messages.proveedores') }}</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Item.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Permission.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Permission.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Permission.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Permisos</span>
            </a>
        </li>
        @endcan
        @can('Configuration.Item.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.Role.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.Role.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.Role.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Roles</span>
            </a>
        </li>
        @endcan
        @can('Configuration.User.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Configuration.User.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Configuration.User.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Configuration.User.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <span class="ml-4">Usuarios</span>
            </a>
        </li>
        @endcan
    {{-- </details>
    <details class="open:bg-white dark:open:bg-white open:ring-1 open:ring-black/5 dark:open:ring-white/10 open:shadow-lg rounded-lg" open>
        <summary class="inline-flex items-center relative px-4 py-3 w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-400" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor"></path>
            </svg>
            <span class="ml-1">Cotización</span>
        </summary>
        --}}
        <li class="relative px-10 py-1">
            {!! request()->routeIs('dashboard') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('dashboard')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
                <span class="ml-4">Dashboard PBI</span>
            </a>
        </li>
        {{-- <li class="my-px">
            {!! request()->routeIs('dashboard') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a href="#"
                class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 bg-gray-100">
                <span class="flex items-center justify-center text-lg text-gray-500">
                    <svg fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        class="h-6 w-6">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </span>
                <span class="ml-3">Dashboard PBI</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">3</span>
            </a>
        </li> --}}

        @can('Home.Menu.index')
        @php
            $user = Illuminate\Support\Facades\Auth::user();
            $count = App\Models\RequestQuote::where('User_id',$user->id)->whereIn('StatusList_id',[1,6,7])->count();
        @endphp
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Home.Menu.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Home.Menu.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Home.Menu.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
                <span class="ml-4">Inicio</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count }}</span>
            </a>
        </li>
        @endcan

        @can('Home.Report.index')
            <li class="relative px-10 py-1">
                {!! request()->routeIs('Home.Report.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Home.Report.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Home.Report.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                    <span class="ml-4">Reportes</span>
                </a>
            </li>
        @endcan

        @can('Purchasing.quoteAssignment.index')
        @php
            $count_asignacion = App\Models\RequestQuote::where('StatusList_id',2)->count();
        @endphp
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Purchasing.quoteAssignment.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Purchasing.quoteAssignment.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Purchasing.quoteAssignment.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                    <path d="M15 19l2 2l4 -4" />
                </svg>
                <span class="ml-4">Asignación</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count_asignacion }}</span>
            </a>
        </li>
        @endcan
        @can('Purchasing.requestQuote.index')
        @php
            $user = Illuminate\Support\Facades\Auth::user();
            if($user->buyer){
                $count_solicitudes = App\Models\RequestQuote::where('Buyer_id',$user->buyer->id)->whereIn('StatusList_id',[3,4,5,6])->count();
            }
        @endphp
        @if ($user->buyer)    
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Purchasing.requestQuote.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Purchasing.requestQuote.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Purchasing.requestQuote.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 17h6" />
                    <path d="M9 13h6" />
                </svg>
                <span class="ml-4">Solicitudes QT</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count_solicitudes }}</span>
            </a>
        </li>
        @endif
        @endcan
        @can('Purchasing.requestQuote.index')
        @php
            $user = Illuminate\Support\Facades\Auth::user();
            if($user->buyer){
                $count_solicitudes = App\Models\RequestQuote::where('Buyer_id',$user->buyer->id)->whereIn('StatusList_id',[25])->count();
            }
        @endphp
        @if ($user->buyer)    
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Purchasing.requestRequisition.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Purchasing.requestRequisition.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Purchasing.requestRequisition.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 17h6" />
                    <path d="M9 13h6" />
                </svg>
                <span class="ml-4">Solicitudes RQ</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count_solicitudes }}</span>
            </a>
        </li>
        @endif
        @endcan
    
        @can('Requisition.AssignedCommodity.index')
        @php
            $count_Commodity = App\Models\RequestQuote::where('StatusList_id',15)->count();
        @endphp
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Requisition.AssignedCommodity.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Requisition.AssignedCommodity.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Requisition.AssignedCommodity.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 9l5 5v7h-5v-4m0 4h-5v-7l5 -5m1 1v-6a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v17h-8" />
                    <path d="M13 7l0 .01" /><path d="M17 7l0 .01" /><path d="M17 11l0 .01" /><path d="M17 15l0 .01" /></svg>
                <span class="ml-4">Commodity</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count_Commodity }}</span>
            </a>
        </li>
        @endcan
        @can('Requisition.ApprovalRequisition.index')
        @php
            $user = Auth::user();
            $departmentIds = $user->authorization->where('Status', 1)->pluck('Department_id');
            $costCenterIds = App\Models\CostCenter::whereIn('Department_id',  $departmentIds)->pluck('id');
            // Obtener el ID del usuario autenticado
            $userId = Auth::id();
            // Consulta base para obtener las líneas de cotización autorizadas para el usuario actual
            $quoteLineQuery = App\Models\QuoteLine::whereHas('costCenter.department.authorization', function ($query) use ($userId) {
                // Filtrar por el ID del usuario y el estado autorizado
                $query->where('User_id', $userId)
                    ->where('Status', true); // Aquí se agrega la condición para el campo Status
            });
            // Obtener las líneas de cotización paginadas
            $quoteLines = $quoteLineQuery->get();
            // Obtener los ID únicos de los QuoteRequest asociados a los QuoteLine
            $quoteRequestIds = $quoteLines->pluck('QuoteRequest_id')->unique();
            
            // Consulta para obtener los QuoteRequest asociados a los QuoteLine sin duplicados
            $query = App\Models\RequestQuote::whereIn('id', $quoteRequestIds)
                                        ->whereIn('StatusList_id',[13])
                                        ->get();
            $count_usara = $query->count();
        @endphp
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Requisition.ApprovalRequisition.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Requisition.ApprovalRequisition.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Requisition.ApprovalRequisition.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. Usara</span>
                {{-- <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count_usara }}</span> --}}
            </a>
        </li>
        @endcan
        @can('Requisition.ApproverRequests.index')
        @php
            $count_usara = App\Models\RequestQuote::where('StatusList_id',13)->count();
        @endphp
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Requisition.ApproverRequests.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Requisition.ApproverRequests.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Requisition.ApproverRequests.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. Solicita</span>
                {{-- <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count_usara }}</span> --}}
            </a>
        </li>
        @endcan

        @can('PurchaseOrder.ApprovalBuyer.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('PurchaseOrder.ApprovalBuyer.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('PurchaseOrder.ApprovalBuyer.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('PurchaseOrder.ApprovalBuyer.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. P.O Comprador</span>
            </a>
        </li>
        @endcan

        @can('PurchaseOrder.ApprovalDirector.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('PurchaseOrder.ApprovalDirector.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('PurchaseOrder.ApprovalDirector.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('PurchaseOrder.ApprovalDirector.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. P.O. Gerente Compras</span>
            </a>
        </li>
        @endcan

        @can('PurchaseOrder.ApprovalVP.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('PurchaseOrder.ApprovalVP.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('PurchaseOrder.ApprovalVP.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('PurchaseOrder.ApprovalVP.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. P.O VPresidente</span>
            </a>
        </li>
        @endcan

        @can('PurchaseOrder.ApprovalPresident.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('PurchaseOrder.ApprovalPresident.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('PurchaseOrder.ApprovalPresident.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('PurchaseOrder.ApprovalPresident.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. P.O. Presidente</span>
            </a>
        </li>
        @endcan
        
    
        @can('RequestInvestment.HomeRI.index')
        @php
            $user = Illuminate\Support\Facades\Auth::user();
            $count = App\Models\RequestInvestment::where('User_id',$user->id)->whereIn('StatusList_id',[17])->count();
        @endphp
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.HomeRI.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.HomeRI.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.HomeRI.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M21 15h-2.5c-.398 0 -.779 .158 -1.061 .439c-.281 .281 -.439 .663 -.439 1.061c0 .398 .158 .779 .439 1.061c.281 .281 .663 .439 1.061 .439h1c.398 0 .779 .158 1.061 .439c.281 .281 .439 .663 .439 1.061c0 .398 -.158 .779 -.439 1.061c-.281 .281 -.663 .439 -1.061 .439h-2.5" />
                    <path d="M19 21v1m0 -8v1" />
                    <path d="M13 21h-7c-.53 0 -1.039 -.211 -1.414 -.586c-.375 -.375 -.586 -.884 -.586 -1.414v-10c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h2m12 3.12v-1.12c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2" /><path d="M16 10v-6c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-4c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414v6m8 0h-8m8 0h1m-9 0h-1" />
                    <path d="M8 14v.01" />
                    <path d="M8 17v.01" />
                    <path d="M12 13.99v.01" />
                    <path d="M12 17v.01" />
                </svg>
                <span class="ml-4">Inicio Solicitud Inversión</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">{{ $count }}</span>
            </a>
        </li>
        @endcan
        
        @can('RequestInvestment.ApprovalBuyer.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.ApprovalBuyer.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.ApprovalBuyer.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.ApprovalBuyer.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. S.I Gerente</span>
            </a>
        </li>
        @endcan
        
        @can('RequestInvestment.ApprovalDirector.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.ApprovalDirector.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.ApprovalDirector.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.ApprovalDirector.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. S.I Gerente Compras</span>
            </a>
        </li>
        @endcan

        @can('RequestInvestment.ApprovalVP.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.ApprovalVP.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.ApprovalVP.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.ApprovalVP.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. S.I. VPresidente</span>
            </a>
        </li>
        @endcan

        @can('RequestInvestment.ApprovalPresident.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.ApprovalPresident.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.ApprovalPresident.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.ApprovalPresident.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. S.I. Presidente</span>
            </a>
        </li>
        @endcan

        @can('RequestInvestment.ApprovalFinance.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.ApprovalFinance.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.ApprovalFinance.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.ApprovalFinance.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. S.I. Finanzas</span>
            </a>
        </li>
        @endcan
        @can('RequestInvestment.ApproverRequests.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('RequestInvestment.ApproverRequests.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('RequestInvestment.ApproverRequests.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('RequestInvestment.ApproverRequests.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                </svg>
                <span class="ml-4">Aprob. S.I. Gerente</span>
            </a>
        </li>
        @endcan

        @can('Requisition.WarehouseReception.index')
        <li class="relative px-10 py-1">
            {!! request()->routeIs('Requisition.WarehouseReception.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 {{ request()->routeIs('Requisition.WarehouseReception.*') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : '' }}" href="{{route('Requisition.WarehouseReception.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 21v-13l9 -4l9 4v13" /><path d="M13 13h4v8h-10v-6h6" /><path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" /></svg>
                <span class="ml-4">Recepción</span>
            </a>
        </li>
        @endcan
    </ul>
</div>
