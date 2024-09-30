<header class="z-10 py-2 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-gray-800 ">
        <div class="flex items-center space-x-4">
            <a class="text-lg font-bold" href="#">
                <?php echo e(config('app.name')); ?>

            </a>
            <button class="p-1 flex items-center rounded-md focus:outline-none focus:shadow-outline-gray" @click="toggleSideMenu" aria-label="Menu">
                <svg class="w-6 h-6 mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>Menu</span>
            </button>
        </div>

        <ul class="flex items-center flex-shrink-0 space-x-4">
            <!-- Language switcher -->
            <li class="flex">
                <select id="lang" onchange="location = this.value;" class="block py-1 px-2 rounded text-sm border border-gray-300 text-gray-900  focus:border-gray-500 focus:outline-none focus:shadow-outline-gray">
                    <option value="" disabled selected><?php echo e(__('Select Language')); ?></option>
                    <option value="<?php echo e(route('lang.switch', 'en')); ?>" <?php echo e(session('applocale') == 'en' ? 'selected' : ''); ?>>
                        🇬🇧 English
                    </option>
                    <option value="<?php echo e(route('lang.switch', 'es')); ?>" <?php echo e(session('applocale') == 'es' ? 'selected' : ''); ?>>
                        🇪🇸 Español
                    </option>
                    <option value="<?php echo e(route('lang.switch', 'ja')); ?>" <?php echo e(session('applocale') == 'ja' ? 'selected' : ''); ?>>
                        🇯🇵 日本語
                    </option>
                </select>
            </li>

            <!-- Theme toggler -->
            <li class="flex">
                <button class="rounded-md focus:outline-none focus:shadow-outline-gray" @click="toggleTheme" aria-label="Toggle color mode">
                    <template x-if="!dark">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </template>
                    <template x-if="dark">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                    </template>
                </button>
            </li>

            <!-- Profile menu -->
            <li class="relative">
                <button class="align-middle rounded-full focus:shadow-outline-gray focus:outline-none" @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true">
                    <img class="object-cover w-8 h-8 rounded-full" src="<?php echo e(Auth::user()->profile_photo_url); ?>" alt="<?php echo e(Auth::user()->name); ?>" aria-hidden="true" />
                </button>
                <template x-if="isProfileMenuOpen">
                    <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md" aria-label="submenu">
                        <li class="flex">
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="/user/profile">
                                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span><?php echo e(__('Profile')); ?></span>
                            </a>
                        </li>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span><?php echo e(__('Logout')); ?></span>
                                </a>
                            </li>
                        </form>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>

<script>
    function toggleSideMenu() {
        document.querySelector('.side-menu').classList.toggle('hidden');
    }

    function toggleTheme() {
        document.documentElement.classList.toggle('dark');
    }

    function toggleProfileMenu() {
        document.querySelector('[x-data="profileMenu"]').isProfileMenuOpen = !document.querySelector('[x-data="profileMenu"]').isProfileMenuOpen;
    }

    function closeProfileMenu() {
        document.querySelector('[x-data="profileMenu"]').isProfileMenuOpen = false;
    }
</script>
<?php /**PATH C:\xampp\htdocs\GESC\resources\views/layouts/navigation-dropdown.blade.php ENDPATH**/ ?>