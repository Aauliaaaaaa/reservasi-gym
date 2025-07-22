<x-app-layout>
  <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-left">Jadwal Latihan</h2>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-black-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
          <tr>
            <th class="px-6 py-3">Nama Customer</th>
            <th class="px-6 py-3">Paket</th>
            <th class="px-6 py-3">Tanggal Latihan</th>
            <th class="px-6 py-3">Jam</th>
            <th class="px-6 py-3">Status Selesai</th>
            <th class="px-6 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jadwals as $jadwal)
            <tr class="bg-white border-b hover:bg-gray-50">
              <td class="px-6 py-4">{{ $jadwal->membership->customer->nama }}</td>
              <td class="px-6 py-4">{{ $jadwal->membership->paket->nama }}</td>
              <td class="px-6 py-4">{{ \Carbon\Carbon::parse($jadwal->tgl_datang)->translatedFormat('l, d F Y') }}</td>
              <td class="px-6 py-4">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
              <td class="px-6 py-4">
                @if($jadwal->selesai)
                  <span class="text-green-500">Selesai</span>
                @else
                  <span class="text-red-500">Belum Selesai</span>
                @endif
              </td>
              <td class="px-6 py-4">
                @if(!$jadwal->selesai)
                  <form action="{{ route('trainer.jadwal.selesai', $jadwal->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Tandai Selesai</button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4">Tidak ada jadwal latihan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</x-app-layout>
