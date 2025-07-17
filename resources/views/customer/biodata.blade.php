<x-app-layout>
    <section class="max-w-5xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold mb-6">Biodata</h2>
        <p class="text-sm mb-6 text-gray-600">Lengkapi atau Perbarui Biodata Sesuai Kartu Identitas Anda!</p> {{-- Ubah teks --}}

        {{-- Pastikan action mengarah ke route UPDATE, dan ada @method('PUT') --}}
        <form action="{{ route('customer.biodata.update') }}" method="POST">
            @csrf
            {{-- @method('PUT')  --}}


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="nama">Nama</label>
                    {{-- Mengisi input dengan data customer atau nilai lama jika validasi gagal --}}
                    <input type="text" name="nama" id="nama" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" value="{{ old('nama', $customer->nama ?? '') }}" required>
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                        <option value="">-- Pilih --</option>
                        {{-- Mengisi select dengan data customer atau nilai lama --}}
                        <option value="Laki-laki" {{ old('jenis_kelamin', $customer->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $customer->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1" for="alamat">Alamat</label>
                    {{-- Mengisi textarea dengan data customer atau nilai lama --}}
                    <textarea name="alamat" id="alamat" rows="5" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" required>{{ old('alamat', $customer->alamat ?? '') }}</textarea>
                    @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6 md:col-span-2">
                    <label class="block text-sm font-medium mb-1" for="no_telp">No. Telp</label>
                    {{-- Mengisi input dengan data customer atau nilai lama --}}
                    <input type="text" name="no_telp" id="no_telp" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" value="{{ old('no_telp', $customer->no_telp ?? '') }}" required>
                    @error('no_telp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</x-app-layout>