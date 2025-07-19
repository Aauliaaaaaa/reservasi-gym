<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 border-b">
                <h2 class="text-2xl font-bold text-gray-900">Bukti Reservasi Saya</h2>
                <p class="mt-1 text-sm text-gray-600">Berikut adalah riwayat semua pemesanan yang telah Anda lakukan.</p>
            </div>
            
            <div class="p-6 md:p-8">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Layanan</th>
                                <th class="px-6 py-3">Tanggal Reservasi</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($memberships as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $item->paket->nama ?? ($item->kategori . ' ' . $item->sub_kategori) }}</td>
                                <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
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
                                <td class="px-6 py-4 flex justify-center items-center gap-2">
                                    <a href="{{ route('customer.reservasi.show', $item->id) }}" class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg text-xs">Detail</a>
                                    
                                    @if(!$item->status_selesai)
                                        {{-- PERBAIKAN: Tombol hanya muncul jika bukan paket Privat --}}
                                        @if(strtolower($item->sub_kategori) != 'privat')
                                            <a href="{{ route('customer.reservasi.edit', $item->id) }}" class="font-medium text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1.5 rounded-lg text-xs">Ubah Jadwal</a>
                                        @else
                                            @if ($item->accepted_trainer === 0)
                                                <a href="{{ route('customer.reservasi.edit.privat', $item->id) }}" class="font-medium text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1.5 rounded-lg text-xs">Ubah Reservasi</a>
                                            @endif
                                        @endif
                                        <form action="{{ route('customer.reservasi.complete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin sesi ini sudah selesai?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg text-xs">Selesai</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                             <tr><td colspan="5" class="px-6 py-4 text-center">Anda belum memiliki riwayat reservasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
