<x-app-layout>
    <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Kelola Syarat dan Ketentuan</h2>

            <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                Tambah Syarat
            </button>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-black-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kategori</th>
                            <th scope="col" class="px-6 py-3">Isi</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                   <tbody>
                    @foreach ($syarat as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->kategori }}</td>
                            <td class="px-6 py-4">{!! nl2br(e($item->isi)) !!}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <button data-modal-target="modal-edit-{{ $item->id }}" data-modal-toggle="modal-edit-{{ $item->id }}" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Edit</button>
                                <form method="POST" action="{{ route('syarat.destroy', $item->id) }}" onsubmit="return confirm('Yakin mau hapus?');">
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
                                    <form method="POST" action="{{ route('syarat.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                            <input type="text" name="kategori" value="{{ $item->kategori }}" class="w-full border rounded-lg p-2">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Isi</label>
                                            <textarea name="isi" rows="5" class="w-full border rounded-lg p-2">{{ $item->isi }}</textarea>
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
                    <form method="POST" action="{{ route('syarat.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                            <input type="text" name="kategori" class="w-full border rounded-lg p-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Isi</label>
                            <textarea name="isi" rows="5" class="w-full border rounded-lg p-2" required></textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>