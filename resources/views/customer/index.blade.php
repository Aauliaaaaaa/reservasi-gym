<x-app-layout>
    <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Kelola Customer</h2>

        <label for="bulan" class="font-medium">Bulan:</label>
                <select id="bulan" name="bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg" onchange="filterKategori()">
                    <option value="">Semua</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
                    <label for="tahun" class="font-medium gap-2">Tahun:</label>
                <select id="tahun" name="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg" onchange="filterKategori()">
                    <option value="">Semua</option>
                    @for ($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
        <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
            Tambah
        </button>
        <form action="{{ route('customer.cetakPdf') }}" method="GET" class="inline-block">
            <input type="hidden" name="bulan" id="bulan-cetak" value="{{ request('bulan') }}">
            <input type="hidden" name="tahun" id="tahun-cetak" value="{{ request('tahun') }}">
            <button type="submit" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                Cetak PDF
            </button>
        </form>
        
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-black-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                        <th scope="col" class="px-6 py-3">No Telp</th>
                        <th scope="col" class="px-6 py-3">Alamat</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($customer->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @else
                    @foreach ($customer as $index => $customer)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $customer->nama }}</td>
                            <td class="px-6 py-4">{{ $customer->jenis_kelamin }}</td>
                            <td class="px-6 py-4">{{ $customer->no_telp }}</td>
                            <td class="px-6 py-4">{{ $customer->alamat }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <!-- Tombol Edit -->
                                <button data-modal-target="modal-edit-{{ $customer->id }}" data-modal-toggle="modal-edit-{{ $customer->id }}" class="text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm">Edit</button>
                                <!-- Tombol Hapus -->
                                <form method="POST" action="{{ route('customer.destroy', $customer->id) }}" onsubmit="return confirm('Yakin mau hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="modal-edit-{{ $customer->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
                            <div class="relative p-4 w-full max-w-2xl mx-auto mt-20">
                                <div class="bg-white rounded-lg shadow p-6">
                                    <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                                            <input type="text" name="nama" value="{{ $customer->nama }}" class="w-full border rounded-lg p-2" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="w-full border rounded-lg p-2" required>
                                                <option value="Laki-laki" {{ $customer->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $customer->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                                            <input type="text" name="no_telp" value="{{ $customer->no_telp }}" class="w-full border rounded-lg p-2" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                                            <textarea name="alamat" rows="5" class="w-full border rounded-lg p-2" required>{{ $customer->alamat }}</textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal Tambah -->
    <div id="modal-tambah" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="relative p-4 w-full max-w-2xl mx-auto mt-20">
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('customer.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="nama" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border rounded-lg p-2" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                        <input type="text" name="no_telp" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                        <textarea name="alamat" rows="5" class="w-full border rounded-lg p-2" required></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function filterKategori() {
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        const url = new URL(window.location.href);
        if (bulan) {
            url.searchParams.set('bulan', bulan);
        } else {
            url.searchParams.delete('bulan');
        }

        if (tahun) {
            url.searchParams.set('tahun', tahun);
        } else {
            url.searchParams.delete('tahun');
        }

        window.location.href = url.toString();
    }

    // Sinkronkan nilai hidden input PDF dengan dropdown
    document.addEventListener('DOMContentLoaded', () => {
        const bulanSelect = document.getElementById('bulan');
        const tahunSelect = document.getElementById('tahun');
        const bulanCetak = document.getElementById('bulan-cetak');
        const tahunCetak = document.getElementById('tahun-cetak');

        bulanSelect.addEventListener('change', () => {
            bulanCetak.value = bulanSelect.value;
        });

        tahunSelect.addEventListener('change', () => {
            tahunCetak.value = tahunSelect.value;
        });
    });
</script>


</x-app-layout>
