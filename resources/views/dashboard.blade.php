{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
<x-app-layout>
    {{-- Hapus div dengan class py-12 agar tidak ada jarak berlebih --}}
    {{-- <div class="py-12"> --}}

        {{-- Gunakan max-w-7xl untuk konsistensi lebar halaman --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">
                Selamat Datang, {{ Auth::user()->name }}!
            </h2>

            <!-- Grid untuk Kartu Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <!-- Card: Member Aktif -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-8 h-8 text-blue-500 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 015.25 0m-5.25 0a3.75 3.75 0 00-5.25 0M3 13.5g.75 2.25 2.25 2.25m4.5-3.86-1.543-.826A9.441 9.441 0 0112 6a9.441 9.441 0 015.293 1.564l-1.543.826m-4.5 3.86a3.75 3.75 0 015.25 0" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Aktif</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jumlahMemberAktif }}</p>
                    </div>
                </div>

                <!-- Card: Jumlah Pelatih -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-green-100 dark:bg-green-900 rounded-full">
                         <svg class="w-8 h-8 text-green-500 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Pelatih</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jumlahPelatih }}</p>
                    </div>
                </div>

                <!-- Card: Total Customer -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                        <svg class="w-8 h-8 text-yellow-500 dark:text-yellow-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.66c.12-.12a.232-.223.335-.328m3.135 3.135A9.37 9.37 0 0112 19.5c-2.621 0-5.022-.993-6.83-2.625" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customer</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jumlahCustomer }}</p>
                    </div>
                </div>

                <!-- Card: Transaksi Bulan Ini -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-8 h-8 text-red-500 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.75A.75.75 0 013 4.5h.75m0 0h.75A.75.75 0 015.25 6v.75m0 0v-.75A.75.75 0 014.5 4.5h-.75M6 13.5V12A2.25 2.25 0 003.75 9.75H3.75A2.25 2.25 0 001.5 12v1.5m1.5 0v-1.5m0 0a60.062 60.062 0 0115.797 2.101" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Transaksi Lunas (Bulan Ini)</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $transaksiBulanIni }}</p>
                    </div>
                </div>
            </div>
            <!-- End Grid -->

            <!-- Tabel Member Baru -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        Member Baru Terdaftar
                    </h3>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">No. Telepon</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($memberBaru as $member)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $member->nama }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $member->no_telp }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $member->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                                @empty
                                 <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="3" class="px-6 py-4 text-center">
                                        Belum ada member baru yang terdaftar.
                                    </td>
                                 </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    {{-- </div> --}}
</x-app-layout>
