<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <section class="max-w-7xl mx-auto my-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6 text-center">Laporan Tahunan</h2>

                <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                    Buat Laporan Tahun Ini
                </button>

                <!-- Tabel Laporan -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-8">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tahun</th>
                                <th scope="col" class="px-6 py-3">Total Member Aktif</th>
                                <th scope="col" class="px-6 py-3">Member Baru</th>
                                <th scope="col" class="px-6 py-3">Total Pendapatan</th>
                                <th scope="col" class="px-6 py-3">Rata-rata Pendapatan/Bulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporanTahunan as $laporan)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $laporan->tahun }}</td>
                                    <td class="px-6 py-4">{{ $laporan->total_member_aktif }}</td>
                                    <td class="px-6 py-4">{{ $laporan->jumlah_member_baru }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($laporan->total_pendapatan) }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($laporan->total_pendapatan / 12) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4 text-gray-500">
                                        Belum ada laporan yang dibuat. Silakan buat laporan baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Tabel Laporan -->

                <!-- Grafik Pertumbuhan Member -->
                <div class="p-4 border rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Grafik Pertumbuhan Member</h3>
                        
                        {{-- PERBAIKAN 1: Ganti route ke owner --}}
                        <form method="GET" action="{{ route('owner.laporan.tahunan') }}">
                             <select name="tahun" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah Laporan -->
    <div id="modal-tambah" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="relative p-4 w-full max-w-md mx-auto mt-20">
            <div class="bg-white rounded-lg shadow p-6">
                 <h3 class="text-xl font-semibold mb-4">Buat Rekap Laporan Tahunan</h3>
                 <p class="text-sm text-gray-600 mb-4">Sistem akan menghitung semua data dari tahun yang dipilih dan menyimpannya sebagai laporan permanen.</p>
                
                {{-- PERBAIKAN 2: Ganti route ke owner --}}
                <form method="POST" action="{{ route('owner.laporan.tahunan.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="tahun" class="block mb-2 text-sm font-medium text-gray-900">Pilih Tahun untuk Direkap</label>
                        <select name="tahun" class="w-full border rounded-lg p-2" required>
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                         <button type="button" data-modal-hide="modal-tambah" class="text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">Batal</button>
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Buat Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const ctx = document.getElementById('growthChart');
        const growthData = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Member Baru',
                data: growthData,
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
