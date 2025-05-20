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
        <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
            <!-- Ganti gambar dengan gambar lokal di folder public/assets -->
            <img src="{{ asset('assets/df.png') }}" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">D-Finance</span>
        </a>

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
                <button type="button" id="dropdownButton"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-kuitansi" data-collapse-toggle="dropdown-kuitansi">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Perencanaan Anggaran</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <ul id="dropdown-kuitansi" class="hidden py-2 space-y-2">
                    <li>
                        <x-nav-link :href="route('skpd.index')" :active="request()->routeIs('skpd')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('SKPD / OPD') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('program.index')" :active="request()->routeIs('program')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('PROGRAM') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('kegiatan.index')" :active="request()->routeIs('kegiatan.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KEGIATAN') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('sub_kegiatan.index')" :active="request()->routeIs('sub_kegiatan.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('SUB KEGIATAN') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('kode_rekening.index')" :active="request()->routeIs('kode_rekening.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KODE REKENING') }}
                        </x-nav-link>
                    </li>
                </ul>
            </li>

            <li>
                <button type="button" id="dropdownButtonCetak"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-cetak-kuitansi" data-collapse-toggle="dropdown-cetak-kuitansi">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                        <path
                            d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"> Cetak Kuitansi</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <ul id="dropdown-cetak-kuitansi" class="hidden py-2 space-y-2">

                    <li>

                        {{-- <x-nav-link :href="route('kode-rekening-bidang.index')"
                            :active="request()->routeIs('kode-rekening-bidang.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KODE REKENING BIDANG') }}
                        </x-nav-link> --}}
                        <x-nav-link :href="route('rincian_belanja_umum.index')" :active="request()->routeIs('rincian_belanja_umum.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('RINCIAN BELANJA UMUM') }}
                        </x-nav-link>
                        {{-- <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a>
                        --}}
                    </li>
                    <li>

                        {{-- <x-nav-link :href="route('kode-rekening-bidang.index')"
                            :active="request()->routeIs('kode-rekening-bidang.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('KODE REKENING BIDANG') }}
                        </x-nav-link> --}}
                        <x-nav-link :href="route('rincian_belanja_sppd.index')" :active="request()->routeIs('rincian_belanja_sppd.index')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            {{ __('RINCIAN BELANJA SPPD') }}
                        </x-nav-link>
                        {{-- <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a>
                        --}}
                    </li>
                    <li>


                        {{-- <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a>
                        --}}
                    </li>

                </ul>
            </li>
            @if (Auth::user()->role !== 'bidang')
                <li>
                    <button type="button" id="dropdownButtonLaporan"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-70"
                        aria-controls="dropdown-laporan" data-collapse-toggle="dropdown-laporan">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"> Laporan </span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <ul id="dropdown-laporan" class="hidden py-2 space-y-2">
                        <li>

                            <x-nav-link :href="route('laporan.index')"
                                class="flex pl-6 items-center w-full p-2 text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                <span class="flex-1 ms-3 whitespace-nowrap">Lap. Rincian Belanja Umum</span>
                            </x-nav-link>
                        </li>
                        <li>

                            <x-nav-link :href="route('laporan_sppd.index')"
                                class="flex pl-6 items-center w-full p-2 text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">


                                <span class="flex-1  ms-3 whitespace-nowrap">Lap. Belanja SPPD</span>
                            </x-nav-link>
                        </li>

                    </ul>
                </li>
            @endif
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
                    <span
                        class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('Data Pegawai') }}</span>
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
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">1</span>
                            --}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('pptks.index')" :active="request()->routeIs('pptk')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data PPTK') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">12</span>
                            --}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('bendahara.index')" :active="request()->routeIs('bendahara')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data Bendahara') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">1</span>
                            --}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('pegawais.index')" :active="request()->routeIs('pegawais')"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75  pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                            <span class="flex-1 ms-3 whitespace-nowrap">{{ __('Data Penerima Kuitansi') }}</span>
                            {{-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            </span> --}}
                        </x-nav-link>
                    </li>

                </ul>

            <li>

                <x-nav-link :href="route('pegawais.index')"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                            d="M8 8v1h4V8m4 7H4a1 1 0 0 1-1-1V5h14v9a1 1 0 0 1-1 1ZM2 1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Penerima Kuitansi</span>
                </x-nav-link>
            </li>
            <li>

                <x-nav-link :href="route('barang.index')"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                            d="M8 8v1h4V8m4 7H4a1 1 0 0 1-1-1V5h14v9a1 1 0 0 1-1 1ZM2 1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Barang</span>
                </x-nav-link>
            </li>
            </li>
        </ul>
        <div id="dropdownUsers"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownUsersButton">
                <li>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Profile') }}</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Log Out') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Register') }}
                    </a>

                    <!-- Form logout yang tersembunyi -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                </li>


            </ul>
        </div>
        <a href="#"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
            id="dropdownUsersButton" data-dropdown-toggle="dropdownUsers">
            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                <path
                    d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">{{ Auth::user()->name }}</span>
            <svg class="w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </a>
    </div>
</aside>






<script src="https://cdn.jsdelivr.net/npm/flowbite@1.5.3/dist/flowbite.min.js"></script>
<script>
    // Ambil elemen untuk dropdown tombol Perencanaan Anggaran
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdown-kuitansi');

    // Ambil elemen untuk dropdown tombol Cetak Kuitansi
    const dropdownButtonCetak = document.getElementById('dropdownButtonCetak');
    const dropdownMenuCetak = document.getElementById('dropdown-cetak-kuitansi');

    // Memeriksa status dropdown pertama (Perencanaan Anggaran) di localStorage saat halaman dimuat
    window.onload = () => {
        // Status untuk dropdown Perencanaan Anggaran
        const dropdownStatus = localStorage.getItem('dropdownOpen');
        console.log('Status Perencanaan Anggaran dari localStorage:', dropdownStatus);
        if (dropdownStatus === 'true') {
            dropdownMenu.classList.remove('hidden');
        } else {
            dropdownMenu.classList.add('hidden');
        }

        // Status untuk dropdown Cetak Kuitansi
        const dropdownStatusCetak = localStorage.getItem('dropdownOpenCetak');
        console.log('Status Cetak Kuitansi dari localStorage:', dropdownStatusCetak);
        if (dropdownStatusCetak === 'true') {
            dropdownMenuCetak.classList.remove('hidden');
        } else {
            dropdownMenuCetak.classList.add('hidden');
        }
    };

    // Menangani klik pada tombol dropdown pertama (Perencanaan Anggaran)
    dropdownButton.addEventListener('click', () => {
        if (dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.remove('hidden');
            localStorage.setItem('dropdownOpen', 'true');
            console.log('Perencanaan Anggaran terbuka, status disimpan: true');
        } else {
            dropdownMenu.classList.add('hidden');
            localStorage.setItem('dropdownOpen', 'false');
            console.log('Perencanaan Anggaran tertutup, status disimpan: false');
        }
    });

    // Menangani klik pada tombol dropdown kedua (Cetak Kuitansi)
    dropdownButtonCetak.addEventListener('click', () => {
        if (dropdownMenuCetak.classList.contains('hidden')) {
            dropdownMenuCetak.classList.remove('hidden');
            localStorage.setItem('dropdownOpenCetak', 'true');
            console.log('Cetak Kuitansi terbuka, status disimpan: true');
        } else {
            dropdownMenuCetak.classList.add('hidden');
            localStorage.setItem('dropdownOpenCetak', 'false');
            console.log('Cetak Kuitansi tertutup, status disimpan: false');
        }
    });
</script>
