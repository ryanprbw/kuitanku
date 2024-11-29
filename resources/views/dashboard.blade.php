<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __("DASAR HUKUM") }}</h3>
                    <ul class="list-disc pl-5 mb-6">
                        <li>Peraturan Pemerintah Nomor 12 Tahun 2019 tentang Pengelolaan Keuangan Daerah.</li>
                        <li>Peraturan Menteri Dalam Negeri Nomor 77 Tahun 2020 tentang Pedoman Teknis Pengelolaan Keuangan Daerah.</li>
                        <li>Peraturan Daerah Kabupaten Tapin Nomor 10 Tahun 2022 tentang Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2023 Tanggal 30 Desember 2022.</li>
                        <li>Peraturan Bupati Tapin Nomor 44 Tahun 2022 tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2023 Tanggal 30 Desember 2022.</li>
                        <li>Peraturan Bupati Nomor 05 Tahun 2014 tentang Pedoman Penyusunan Standar Operasional Prosedur Penyelenggaraan Pemerintah di Lingkungan Kabupaten Tapin.</li>
                        <li>Peraturan Bupati Nomor 52 Tahun 2021 tentang Pedoman Penyusunan Standar Pelayanan Publik.</li>
                    </ul>

                    <h3 class="text-lg font-semibold mb-4">{{ __("RUANG LINGKUP") }}</h3>
                    <p class="mb-6">Prosedur ini berlaku di Dinas Kependudukan dan Pencatatan Sipil Kabupaten Tapin mulai dari menerima berkas belanja dan perjalanan dinas sampai dengan proses pencairan.</p>

                    <h3 class="text-lg font-semibold mb-4">{{ __("RINGKASAN PROSEDUR") }}</h3>
                    <p class="mb-6">
                        Berkas / Surat Pertanggung Jawaban atas Belanja kegiatan dan Perjalanan Dinas diserahkan oleh PPTK atau Pelaksana Perjalanan Dinas kepada PPK untuk di Verifikasi, kemudian di Cek kembali oleh Bendahara Pengeluaran selanjutnya ditandatangani oleh Kepala Dinas / Pengguna Anggaran dan kemudian Bendahara Pengeluaran melakukan penginputan ke Link FMIS serta melanjutkan proses pencairan melalui Link Cash Management System (CMS) Bank Kalsel.
                    </p>

                    <h3 class="text-lg font-semibold mb-4">{{ __("ISTILAH DAN DEFINISI") }}</h3>
                    <ul class="list-disc pl-5 mb-6">
                        <li><strong>PPTK:</strong> Pejabat Pelaksana Teknis Kegiatan</li>
                        <li><strong>PPK:</strong> Pejabat Penatausahaan Keuangan</li>
                    </ul>

                    <h3 class="text-lg font-semibold mb-4">{{ __("ALUR PEMBAYARAN BELANJA DAN PERJALANAN DINAS") }}</h3>
                    <table class="min-w-full border-collapse border border-gray-300 mb-6">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">NO.</th>
                                <th class="border border-gray-300 px-4 py-2">KEGIATAN</th>
                                <th class="border border-gray-300 px-4 py-2">PPTK/Pelaksana Perjalanan Dinas</th>
                                <th class="border border-gray-300 px-4 py-2">PPK</th>
                                <th class="border border-gray-300 px-4 py-2">Bendahara Pengeluaran</th>
                                <th class="border border-gray-300 px-4 py-2">Pengguna Anggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">1</td>
                                <td class="border border-gray-300 px-4 py-2">Membuat kuitansi pembayaran beserta bukti pendukung</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">2</td>
                                <td class="border border-gray-300 px-4 py-2">Menerima berkas pembayaran dan melakukan verifikasi</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">3</td>
                                <td class="border border-gray-300 px-4 py-2">Menerima berkas yang telah diverifikasi</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">4</td>
                                <td class="border border-gray-300 px-4 py-2">Menandatangani berkas yang telah diverifikasi</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">5</td>
                                <td class="border border-gray-300 px-4 py-2">Menandatangani berkas yang telah ditandatangani Pengguna Anggaran</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">6</td>
                                <td class="border border-gray-300 px-4 py-2">Melakukan Input Berkas/Bukti Pengeluaran ke FMIS</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">7</td>
                                <td class="border border-gray-300 px-4 py-2">Melakukan Input Berkas/Bukti Pengeluaran ke CMS</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">8</td>
                                <td class="border border-gray-300 px-4 py-2">Melakukan Proses Transfer di CMS</td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 class="text-lg font-semibold mb-4">{{ __("KEPALA DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KABUPATEN TAPIN") }}</h3>
                    <p class="font-bold">Hj. Rina Indriani, ST</p>
                    <p>NIP. 19820311 200501 2 017</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
