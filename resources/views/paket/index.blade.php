<x-app-layout>
    <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Kelola Paket</h2>

        <!-- Tombol untuk membuka modal tambah paket -->
        <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
            Tambah Paket
        </button>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-black-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Harga</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paket as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->kategori }}</td>
                            <td class="px-6 py-4">{{ $item->nama }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <!-- Tombol Edit -->
                                <button data-modal-target="modal-edit-{{ $item->id }}" data-modal-toggle="modal-edit-{{ $item->id }}" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Edit</button>

                                <!-- Tombol Hapus -->
                                <form method="POST" action="{{ route('paket.destroy', $item->id) }}" onsubmit="return confirm('Yakin mau hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="modal-edit-{{ $item->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
                            <div class="relative p-4 w-full max-w-2xl mx-auto mt-20">
                                <div class="bg-white rounded-lg shadow p-6">
                                    <form method="POST" action="{{ route('paket.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                            <select name="kategori" class="w-full border rounded-lg p-2" required>
                                                @foreach (['GYM', 'BOXING', 'MUAY THAI', 'CLASS'] as $kategori)
                                                    <option value="{{ $kategori }}" {{ $item->kategori == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Paket</label>
                                            <input type="text" name="nama" value="{{ $item->nama }}" class="w-full border rounded-lg p-2" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Harga</label>
                                            <input type="number" name="harga" value="{{ $item->harga }}" class="w-full border rounded-lg p-2" required>
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
                <form method="POST" action="{{ route('paket.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                        <select name="kategori" class="w-full border rounded-lg p-2" required>
                            <option value="">Pilih Kategori</option>
                            <option value="GYM">GYM</option>
                            <option value="BOXING">BOXING</option>
                            <option value="MUAY THAI">MUAY THAI</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama Paket</label>
                        <input type="text" name="nama" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Harga</label>
                        <input type="number" name="harga" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
