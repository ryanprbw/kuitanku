<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('skpd.index')" :active="request()->routeIs('skpd.index')">
                        {{ __('SKPD / OPD') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('program.index')" :active="request()->routeIs('program.index')">
                        {{ __('Program') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('kegiatan.index')" :active="request()->routeIs('kegiatan.index')">
                        {{ __('Kegiatan') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('sub_kegiatan.index')" :active="request()->routeIs('sub_kegiatan.index')">
                        {{ __('Sub Kegiatan') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('kode_rekening.index')" :active="request()->routeIs('kode_rekening.index')">
                        {{ __('Kode Rekening') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('rincian_belanja_umum.index')" :active="request()->routeIs('rincian_belanja_umum.index')">
                        {{ __('Rincian Belanja Umum') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500  sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75  group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </x-nav-link>
            </li>

            {{-- Kuitansi Bar --}}

            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75  group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-kuitansi" data-collapse-toggle="dropdown-kuitansi">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                        <path
                            d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Kuitansi</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-kuitansi" class="hidden py-2 space-y-2">
                    <li>
                        <x-nav-link :href="route('skpd.index')" :active="request()->routeIs('skpd')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('SKPD / OPD') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Products</a> --}}
                    </li>
                    <li>
                        <x-nav-link :href="route('program.index')" :active="request()->routeIs('program')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('PROGRAM') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>
                    <li>
                        <x-nav-link :href="route('kegiatan.index')" :active="request()->routeIs('kegiatan.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KEGIATAN') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>
                    <li>
                        <x-nav-link :href="route('sub_kegiatan.index')" :active="request()->routeIs('sub_kegiatan.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('SUB KEGIATAN') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>
                    <li>

                        <x-nav-link :href="route('kode_rekening.index')" :active="request()->routeIs('kode_rekening.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KODE REKENING') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>
                    <li>

                        {{-- <x-nav-link :href="route('kode-rekening-bidang.index')" :active="request()->routeIs('kode-rekening-bidang.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KODE REKENING BIDANG') }}
                        </x-nav-link> --}}
                        <x-nav-link :href="route('rincian_belanja_umum.index')" :active="request()->routeIs('rincian_belanja_umum.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('RINCIAN BELANJA UMUM') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>
                    <li>

                        {{-- <x-nav-link :href="route('kode-rekening-bidang.index')" :active="request()->routeIs('kode-rekening-bidang.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KODE REKENING BIDANG') }}
                        </x-nav-link> --}}
                        <x-nav-link :href="route('rincian_belanja_sppd.index')" :active="request()->routeIs('rincian_belanja_sppd.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('RINCIAN BELANJA SPPD') }}
                        </x-nav-link>
                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>
                    <li>


                        {{-- <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a> --}}
                    </li>

                </ul>
            </li>

            {{-- Data Pegawai --}}
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75  group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-pegawai" data-collapse-toggle="dropdown-pegawai">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 18">
                        <path
                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('Data Pegawai') }}</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-pegawai" class="hidden py-2 space-y-2">
                    <li>
                        <x-nav-link :href="route('kepala_dinas.index')" :active="request()->routeIs('kepala_dinas')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data Kepala Dinas') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">1</span> --}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('pptks.index')" :active="request()->routeIs('pptk')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data PPTK') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">12</span> --}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('bendahara.index')" :active="request()->routeIs('bendahara')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data Bendahara') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">1</span> --}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('pegawais.index')" :active="request()->routeIs('pegawais')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data Penerima Kuitansi') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300"> </span> --}}
                        </x-nav-link>
                    </li>
                    
                </ul>
                <li>
                    <x-nav-link :href="route('laporan.index')" class="flex items-center w-full p-2 text-gray-900 transition duration-75  group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M8 8v1h4V8m4 7H4a1 1 0 0 1-1-1V5h14v9a1 1 0 0 1-1 1ZM2 1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                        </svg>
                       <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
                    </x-nav-link>
                 </li>
            </li>
        </ul>
    </div>
</aside>






<script src="https://cdn.jsdelivr.net/npm/flowbite@1.5.3/dist/flowbite.min.js"></script>
<script>
    const dropdownButton = document.querySelector('[data-dropdown-toggle="dropdown"]');
    const dropdownMenu = document.querySelector('#dropdown');

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });
</script>