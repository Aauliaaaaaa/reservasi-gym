<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">
            Selamat Datang, {{ Auth::user()->name }}!
        </h2>

        <!-- Grid untuk Kartu Statistik Customer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <!-- Card: Reservasi Sedang Berjalan -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-8 h-8 text-blue-500 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0011.667 0l3.181-3.183m-4.991 0l-3.182-3.182a8.25 8.25 0 00-11.667 0l-3.181 3.182M19.5 12h-4.992a2.25 2.25 0 01-2.25-2.25V5.25m0 0h4.992a2.25 2.25 0 002.25-2.25V3m-4.992 0l-3.182 3.182a8.25 8.25 0 00-11.667 0l-3.181-3.182" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reservasi Sedang Berjalan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reservasiBerjalan }}</p>
                </div>
            </div>

            <!-- Card: Reservasi Selesai -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                <div class="p-4 bg-green-100 dark:bg-green-900 rounded-full">
                     <svg class="w-8 h-8 text-green-500 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reservasi Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reservasiSelesai }}</p>
                </div>
            </div>
        </div>
        <!-- End Grid -->

        <!-- Tabel Riwayat Membership -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Riwayat Membership Terbaru
                </h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Layanan</th>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                <th scope="col" class="px-6 py-3">Status Pembayaran</th>
                                <th scope="col" class="px-6 py-3">Status Membership</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatMembership as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->paket->nama ?? ($item->kategori . ' ' . $item->sub_kategori) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai ?? $item->tgl_datang)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'lunas')
                                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Lunas</span>
                                    @else
                                        <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->sub_kategori === 'Privat' || $item->sub_kategori === 'Insidental')
                                        @if ($item->accepted_trainer)
                                            @if ($item->status_selesai)
                                                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">Selesai</span>
                                            @else
                                                <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">Aktif</span>
                                            @endif
                                        @elseif ($item->accepted_trainer === 0)
                                            <span class="px-2 py-1 font-semibold leading-tight text-red-500 bg-red-100 rounded-full">Ditolak Pelatih</span>
                                        @else
                                            <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">Menunggu Pelatih</span>
                                        @endif
                                    @else
                                        @if($item->status_selesai)
                                            <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">Selesai</span>
                                        @else
                                            <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">Aktif</span>
                                        @endif
                                    @endif
                                    @if ($item->accepted_trainer === 0)
                                        <p class="mt-2">Alasan: {{ $item->reason }}</p>
                                    @endif
                                </td>
                            </tr>
                            @empty
                             <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="4" class="px-6 py-4 text-center">
                                    Anda belum memiliki riwayat membership.
                                </td>
                             </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
