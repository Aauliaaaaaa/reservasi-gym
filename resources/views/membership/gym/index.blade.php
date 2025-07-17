<x-app-layout>
    <section class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Membership / Gym</h2>

            <div class="flex items-center gap-2 mb-4">
                <label for="kategori" class="font-medium">Kategori:</label>
                <select id="kategori" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="filterKategori()">
                    <option value="Privat" {{ request('kategori') == 'Privat' ? 'selected' : '' }}>Privat</option>
                    <option value="Harian" {{ request('kategori') == 'Harian' ? 'selected' : '' }}>Harian</option>
                    <option value="Bulanan" {{ request('kategori') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>
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
                <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah"
                    class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-lg text-sm">Tambah</button>
                   <a href="{{ route('membership.gym.cetak_pdf', ['kategori' => request('kategori'), 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank">
                        <button class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-lg text-sm">Cetak PDF</button>
                    </a>
            </div>

            {{-- Bagian Tabel (tidak ada perubahan) --}}
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-sm font-semibold">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            @if($subKategori == 'Privat')
                                <th class="px-4 py-2">Pelatih</th>
                            @elseif($subKategori == 'Harian')
                                <th class="px-4 py-2">Tgl Gym</th>
                            @elseif($subKategori == 'Bulanan')
                                <th class="px-4 py-2">Paket</th>
                                <th class="px-4 py-2">Tgl Mulai</th>
                                <th class="px-4 py-2">Tgl Selesai</th>
                            @endif
                            <th class="px-4 py-2">Alamat</th>
                            <th class="px-4 py-2">No. Telp</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Bukti Bayar</th>
                            <th class="px-4 py-2 text-center">Status Pembayaran</th>
                            <th class="px-4 py-2 text-center">Status Membership</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($memberships as $index => $m)
                            <tr class="border-t {{ $m->status_selesai ? 'bg-gray-200 text-gray-600 italic' : '' }}">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $m->customer->nama }}</td>
                                @if($subKategori == 'Privat')
                                    <td class="px-4 py-2">{{ $m->pelatih->nama ?? '-' }}</td>
                                @elseif($subKategori == 'Harian')
                                    <td class="px-4 py-2">{{ $m->tgl_datang }}</td>
                                @elseif($subKategori == 'Bulanan')
                                    <td class="px-4 py-2">{{ $m->paket->nama ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $m->tgl_mulai }}</td>
                                    <td class="px-4 py-2">{{ $m->tgl_selesai }}</td>
                                @endif
                                <td class="px-4 py-2">{{ $m->customer->alamat }}</td>
                                <td class="px-4 py-2">{{ $m->customer->no_telp }}</td>
                                <td class="px-4 py-2">
                                    Rp {{ number_format($m->paket->harga ?? 0) }}
                                </td>
                                <td class="px-4 py-2">
                                    @if($m->bukti_bayar)
                                        <a href="{{ asset('storage/' . $m->bukti_bayar) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400 italic">Belum upload</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if($m->status == 'lunas')
                                        <button class="bg-green-500 text-white text-xs px-3 py-1 rounded" disabled>Lunas</button>
                                    @else
                                        <form action="{{ route('membership.update_status', $m->id) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">Belum Lunas</button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if($m->status_selesai)
                                        <button class="bg-gray-500 text-white text-xs px-3 py-1 rounded" disabled>Selesai</button>
                                    @else
                                        <form action="{{ route('membership.update_status_selesai', $m->id) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button class="bg-indigo-500 text-white text-xs px-3 py-1 rounded hover:bg-indigo-600">Tandai Selesai</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center py-4 text-gray-500">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Modal Tambah --}}
    <div id="modal-tambah" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-40">
        <div class="relative w-full max-w-2xl max-h-full mx-auto mt-24">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold mb-4">Tambah Membership Gym</h3>
                <form method="POST" action="{{ route('membership.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kategori" value="Gym">
                    <input type="hidden" name="sub_kategori" id="modal_sub_kategori" value="{{ $subKategori }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Customer (Selalu Tampil) --}}
                        <div>
                            <label class="block text-sm font-medium">Customer</label>
                            <select name="customer_id" class="w-full border rounded p-2" required>
                                <option value="">-- Pilih --</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- PERUBAHAN 1: Tambahkan ID unik pada pembungkus (div) setiap field --}}

                        {{-- Field untuk Pelatih (Privat) --}}
                        <div id="modal-field-pelatih">
                            <label class="block text-sm font-medium">Pelatih</label>
                            <select name="pelatih_id" class="w-full border rounded p-2">
                                <option value="">-- Pilih --</option>
                                @foreach($pelatih as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Field untuk Paket (Bulanan) --}}
                        <div id="modal-field-paket">
                            <label class="block text-sm font-medium">Paket</label>
                            <select name="paket_id" class="w-full border rounded p-2">
                                <option value="">-- Pilih --</option>
                                @foreach($paket as $pak)
                                    <option value="{{ $pak->id }}">{{ $pak->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Field untuk Tgl Mulai (Bulanan) --}}
                        <div id="modal-field-tgl_mulai">
                            <label class="block text-sm font-medium">Tgl Mulai</label>
                            <input type="date" name="tgl_mulai" class="w-full border rounded p-2">
                        </div>

                        {{-- Field untuk Tgl Selesai (Bulanan) --}}
                        <div id="modal-field-tgl_selesai">
                            <label class="block text-sm font-medium">Tgl Selesai</label>
                            <input type="date" name="tgl_selesai" class="w-full border rounded p-2">
                        </div>

                        {{-- Field untuk Tgl Datang (Harian) --}}
                        <div id="modal-field-tgl_datang">
                            <label class="block text-sm font-medium">Tgl Datang</label>
                            <input type="date" name="tgl_datang" class="w-full border rounded p-2">
                        </div>

                        {{-- Bukti Pembayaran (Selalu Tampil) --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-medium">Bukti Pembayaran (Opsional)</label>
                            <input type="file" name="bukti_bayar" class="w-full border rounded p-2">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" data-modal-hide="modal-tambah" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- PERUBAHAN 2: Ganti script dengan yang ini --}}
    <script>
        // function filterKategori() {
        //     const kategori = document.getElementById('kategori').value;
        //     const bulan = document.getElementById('bulan').value;
        //     let query = `?kategori=${kategori}`;
        //     if (bulan) query += `&bulan=${bulan}`;
        //     window.location.href = query;
        // }
         function filterKategori() {
            const kategori = document.getElementById('kategori').value;
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;

            const url = new URL(window.location.href);
            url.searchParams.set('kategori', kategori);

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

        function updateModalFields(selectedKategori) {
            const pelatihField = document.getElementById('modal-field-pelatih');
            const paketField = document.getElementById('modal-field-paket');
            const tglMulaiField = document.getElementById('modal-field-tgl_mulai');
            const tglSelesaiField = document.getElementById('modal-field-tgl_selesai');
            const tglDatangField = document.getElementById('modal-field-tgl_datang');

            // Sembunyikan semua field dinamis
            pelatihField.style.display = 'none';
            paketField.style.display = 'none';
            tglMulaiField.style.display = 'none';
            tglSelesaiField.style.display = 'none';
            tglDatangField.style.display = 'none';

            // Tampilkan field berdasarkan kategori yang dipilih
            if (selectedKategori === 'Privat') {
                paketField.style.display = 'block'; // <-- PERBAIKAN 3: Tampilkan paket
                pelatihField.style.display = 'block';
            } else if (selectedKategori === 'Harian') {
                paketField.style.display = 'block';
                tglDatangField.style.display = 'block';
            } else if (selectedKategori === 'Bulanan') {
                paketField.style.display = 'block';
                tglMulaiField.style.display = 'block';
                tglSelesaiField.style.display = 'block';
            }
        }

        document.querySelector('[data-modal-toggle="modal-tambah"]').addEventListener('click', function() {
            const selectedKategori = document.getElementById('kategori').value;
            document.getElementById('modal_sub_kategori').value = selectedKategori;
            updateModalFields(selectedKategori);
        });
    </script>
</x-app-layout>
