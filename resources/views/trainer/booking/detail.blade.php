<x-app-layout>
  <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-left">
        <a href="{{ route('trainer.booking.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out mb-4">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back
        </a>
      Detail Booking Membership
    </h2>

    <div class="relative overflow-x-auto sm:rounded-lg">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-2">Customer Information</h3>
          <p><strong>Nama:</strong> {{ $dataMembership->customer->nama }}</p>
          <p><strong>Jenis Kelamin:</strong> {{ $dataMembership->customer->jenis_kelamin }}</p>
          @if ($dataMembership->sub_kategori === 'Insidental')
            <p class="mt-2 text-blue-500">
              <span class="font-semibold text-gray-800">Tanggal Datang:</span>
              {{ \Carbon\Carbon::parse($dataMembership->tgl_datang)->translatedFormat('l, d F Y') }}
            </p>
          @endif
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-2">Paket Information</h3>
          <p><strong>Paket:</strong> {{ $dataMembership->paket->nama }}</p>
          <p><strong>Status Selesai:</strong> 
            @if ($dataMembership->status_selesai)
              <span class="text-green-500">Selesai</span>
            @else
              <span class="text-red-500">Belum Selesai</span>
            @endif
          </p>
          @if ($dataMembership->sub_kategori === 'Insidental' && $dataMembership->accepted_trainer && !$dataMembership->status_selesai)
            <form action="{{ route('trainer.booking.selesai', $dataMembership->id) }}" method="POST" class="mt-4">
              @csrf
              @method('PATCH')
              <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">
                Tandai Selesai
              </button>
            </form>
          @endif
        </div>
      </div>

      @if ($dataMembership->sub_kategori === 'Privat')
      <div class="mt-6 border p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Detail Membership</h3>
        <table class="w-full text-sm text-left text-black-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3">Tanggal Datang</th>
              <th scope="col" class="px-6 py-3">Jam Mulai</th>
              <th scope="col" class="px-6 py-3">Jam Selesai</th>
              <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($dataMembership->membershipDetails as $detail)
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($detail->tgl_datang)->translatedFormat('l, d F Y') }}</td>
                <td class="px-6 py-4">{{ $detail->jam_mulai }}</td>
                <td class="px-6 py-4">{{ $detail->jam_selesai }}</td>
                <td class="px-6 py-4">
                  @if ($dataMembership->accepted_trainer)
                    @if ($detail->selesai)
                      <span class="text-green-500">Selesai</span>
                    @else
                      <form action="{{ route('booking.selesai.private', [$dataMembership->id, $detail->id]) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Selesai</button>
                      </form>
                    @endif
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </section>
</x-app-layout>