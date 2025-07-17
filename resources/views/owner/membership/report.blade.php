<x-app-layout>
    <section class="max-w-7xl mx-auto my-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6 text-center">Laporan Data Membership</h2>
                
                <!-- Form Filter -->
                <form method="GET" action="{{ route('owner.membership.report') }}" class="mb-6 p-4 bg-gray-50 rounded-lg border">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-6 items-end">
                        <!-- Filter Kategori -->
                        <div>
                            <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900">Kategori Utama</label>
                            <select id="kategori" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Semua</option>
                                <option value="Gym" {{ request('kategori') == 'Gym' ? 'selected' : '' }}>Gym</option>
                                <option value="Muay Thai" {{ request('kategori') == 'Muay Thai' ? 'selected' : '' }}>Muay Thai</option>
                                <option value="Boxing" {{ request('kategori') == 'Boxing' ? 'selected' : '' }}>Boxing</option>
                            </select>
                        </div>
                        <!-- Filter Sub Kategori -->
                        <div>
                            <label for="sub_kategori" class="block mb-2 text-sm font-medium text-gray-900">Jenis Paket</label>
                            <select id="sub_kategori" name="sub_kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Semua</option>
                                <option value="Privat" {{ request('sub_kategori') == 'Privat' ? 'selected' : '' }}>Privat</option>
                                <option value="Harian" {{ request('sub_kategori') == 'Harian' ? 'selected' : '' }}>Harian</option>
                                <option value="Bulanan" {{ request('sub_kategori') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                                <option value="Reguler" {{ request('sub_kategori') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Insidental" {{ request('sub_kategori') == 'Insidental' ? 'selected' : '' }}>Insidental</option>
                            </select>
                        </div>
                        <!-- Filter Bulan -->
                        <div>
                            <label for="bulan" class="block mb-2 text-sm font-medium text-gray-900">Bulan</label>
                            <select id="bulan" name="bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Semua</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="tahun" class="block mb-2 text-sm font-medium text-gray-900">Tahun</label>
                            <select id="tahun" name="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Semua</option>
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Filter Data</button>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('owner.membership.pdf', request()->all()) }}" target="_blank" class="w-full text-center text-white bg-green-800 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Cetak PDF</a>
                        </div>
                    </div>                    
                </form>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Tgl Reservasi</th>
                                <th scope="col" class="px-6 py-3">Nama Customer</th>
                                <th scope="col" class="px-6 py-3">Layanan</th>
                                <th scope="col" class="px-6 py-3">Paket</th>
                                <th scope="col" class="px-6 py-3">Pelatih</th>
                                <th scope="col" class="px-6 py-3">Alamat</th>
                                <th scope="col" class="px-6 py-3">No. Telp</th>
                                <th scope="col" class="px-6 py-3">Harga</th>
                                <th scope="col" class="px-6 py-3">Status Bayar</th>
                                <th scope="col" class="px-6 py-3">Status Sesi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($memberships as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $loop->iteration + ($memberships->currentPage() - 1) * $memberships->perPage() }}</td>
                                    <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->customer->nama ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $item->kategori }}</td>
                                    <td class="px-6 py-4">{{ $item->paket->nama ?? $item->sub_kategori }}</td>
                                    <td class="px-6 py-4">{{ $item->pelatih->nama ?? '' }}</td>
                                    <td class="px-6 py-4">{{ $item->customer->alamat}}</td>
                                    <td class="px-6 py-4">{{ $item->customer->no_telp}}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($item->paket->harga ?? 0) }}</td>
                                    <td class="px-6 py-4">
                                         @if($item->status == 'lunas')
                                            <span class="px-2 py-1 font-semibold text-xs leading-tight text-green-700 bg-green-100 rounded-full">Lunas</span>
                                        @else
                                            <span class="px-2 py-1 font-semibold text-xs leading-tight text-yellow-700 bg-yellow-100 rounded-full">Belum Lunas</span>
                                        @endif
                                    </td>
                                     <td class="px-6 py-4">
                                         @if($item->status_selesai)
                                            <span class="px-2 py-1 font-semibold text-xs leading-tight text-gray-700 bg-gray-100 rounded-full">Selesai</span>
                                        @else
                                            <span class="px-2 py-1 font-semibold text-xs leading-tight text-blue-700 bg-blue-100 rounded-full">Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data yang cocok dengan filter yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginasi -->
                <div class="mt-4">
                    {{ $memberships->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
