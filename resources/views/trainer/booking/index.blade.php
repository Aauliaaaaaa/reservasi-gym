<x-app-layout>
  <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-left">Booking Membership</h2>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-black-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Customer</th>
                    <th scope="col" class="px-6 py-3">Paket</th>
                    <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                    <th scope="col" class="px-6 py-3">Status Selesai</th>
                    <th scope="col" class="px-6 py-3">Status Diterima</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
              @forelse($memberships as $membership)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $membership->customer->nama }}</td>
                    <td class="px-6 py-4">{{ $membership->paket->nama }}</td>
                    <td class="px-6 py-4">{{ $membership->customer->jenis_kelamin }}</td>
                    <td class="px-6 py-4">
                      @if ($membership->status_selesai)
                        <span class="text-green-500">Selesai</span>
                      @else
                        <span class="text-red-500">Belum Selesai</span>
                      @endif
                    </td>
                    <td class="px-6 py-4">
                      @if ($membership->accepted_trainer === null)
                        <span class="text-gray-500">Menunggu</span>
                      @elseif ($membership->accepted_trainer)
                        <span class="text-green-500">Diterima</span>
                      @else
                        <span class="text-red-500">Ditolak</span>
                      @endif
                    <td>
                      <a href="{{ route('trainer.booking.detail', $membership->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-lg text-sm">Detail</a>

                      @if ($membership->accepted_trainer === null)
                        <form action="{{ route('trainer.booking.accept', $membership->id) }}" method="POST" class="inline-block">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Terima</button>
                        </form>

                        <button data-modal-target="modal-reject-{{ $membership->id }}" data-modal-toggle="modal-reject-{{ $membership->id }}" type="button" class="text-white bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg text-sm">Tolak</button>
                      @endif
                    </td>
                </tr>
                <div id="modal-reject-{{ $membership->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
                  <div class="relative p-4 w-full max-w-2xl mx-auto mt-20">
                      <div class="bg-white rounded-lg shadow p-6">
                          <form method="POST" action="{{ route('trainer.booking.reject', $membership->id) }}">
                              @csrf
                              @method('PATCH')
                              <div class="mb-4">
                                  <label class="block mb-2 text-sm font-medium text-gray-900">Alasan</label>
                                  <textarea name="reason" rows="5" class="w-full border rounded-lg p-2" required></textarea>
                              </div>
                              <div class="flex justify-end gap-2">
                                  <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">
                                    Tolak
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              @empty
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada data</td>
                </tr>
              @endforelse
            </tbody>
        </table>
    </div>
  </section>
</x-app-layout>