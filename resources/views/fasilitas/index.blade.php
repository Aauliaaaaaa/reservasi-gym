<x-app-layout>
    <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Kelola Fasilitas Gym</h2>

        <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
            Tambah Fasilitas
        </button>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Foto</th>
                        <th scope="col" class="px-6 py-3">Keterangan</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fasilitas as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="px-6 py-4">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="w-16 h-16 object-cover rounded-md">
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{!! nl2br(e($item->keterangan)) !!}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <button data-modal-target="modal-edit-{{ $item->id }}" data-modal-toggle="modal-edit-{{ $item->id }}" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Edit</button>
                                <form method="POST" action="{{ route('fasilitas.destroy', $item->id) }}" onsubmit="return confirm('Yakin mau hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg text-sm">Hapus</button>
                                </form>
                                <button data-modal-target="modal-detail-{{ $item->id }}" data-modal-toggle="modal-detail-{{ $item->id }}" class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 rounded-lg text-sm">Detail</button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="modal-edit-{{ $item->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
                            <div class="relative p-4 w-full max-w-2xl mx-auto mt-20">
                                <div class="bg-white rounded-lg shadow p-6">
                                   <form method="POST" action="{{ route('fasilitas.update', ['fasilitas' => $item->id]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                                            <input type="text" name="nama" value="{{ $item->nama }}" class="w-full border rounded-lg p-2" maxlength="20" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Foto (biarkan kosong jika tidak ingin ganti)</label>
                                            <input type="file" name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                                            <textarea name="keterangan" rows="5" class="w-full border rounded-lg p-2">{{ $item->keterangan }}</textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal Tambah -->
    <div id="modal-tambah" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="relative p-4 w-full max-w-2xl mx-auto mt-20">
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('fasilitas.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="nama" class="w-full border rounded-lg p-2" maxlength="20" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Foto</label>
                        <input type="file" name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                        <textarea name="keterangan" rows="5" class="w-full border rounded-lg p-2"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    @foreach ($fasilitas as $item)
        <div id="modal-detail-{{ $item->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="relative p-4 w-full max-w-4xl mx-auto mt-20">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Riwayat Detail Alat: {{ $item->nama }}</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-black-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Foto</th>
                                    <th class="px-6 py-3">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->detailAlat as $detail)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($detail->tanggal)->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($detail->foto)
                                                <img src="{{ asset('storage/' . $detail->foto) }}" alt="Foto" class="w-16 h-16 object-cover rounded-md">
                                            @else
                                                <span class="text-gray-400 text-sm">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{!! nl2br(e($detail->kondisi)) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- form detail alat --}}
                    <hr class="my-6">
                        <h4 class="text-lg font-bold mb-2">Tambah Monitoring Baru</h4>
                        <form method="POST" action="{{ route('detail-alat.store') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="hidden" name="fasilitas_id" value="{{ $item->id }}">

                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Tanggal</label>
                                <input type="date" name="tanggal" class="w-full border rounded-lg p-2" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Foto (Opsional)</label>
                                <input type="file" name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-900">Kondisi</label>
                                <textarea name="kondisi" rows="3" class="w-full border rounded-lg p-2" required></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Tambah</button>
                            </div>
                        </form>
                        
                    <div class="flex justify-end mt-4">
                        <button data-modal-hide="modal-detail-{{ $item->id }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
