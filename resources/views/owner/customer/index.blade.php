<x-app-layout>
    <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Data Customer</h2>

            <label for="bulan" class="font-medium">Bulan:</label>
            <select id="bulan" name="bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg" onchange="filterKategori()">
                <option value="">Semua</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                @endfor
            </select>
            <label for="tahun" class="font-medium ml-4">Tahun:</label>
            <select id="tahun" name="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg" onchange="filterKategori()">
                <option value="">Semua</option>
                @for ($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <form action="{{ route('owner.customer.cetak.pdf') }}" method="GET" class="inline-block">
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
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                            <th scope="col" class="px-6 py-3">No Telp</th>
                            <th scope="col" class="px-6 py-3">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $index => $customer)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $customer->nama }}</td>
                                <td class="px-6 py-4">{{ $customer->jenis_kelamin }}</td>
                                <td class="px-6 py-4">{{ $customer->no_telp }}</td>
                                <td class="px-6 py-4">{{ $customer->alamat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Data customer tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

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
