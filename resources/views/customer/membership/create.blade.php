<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Pemesanan Membership {{ $kategori_utama }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Silakan lengkapi detail reservasi Anda di bawah ini.
                </p>
            </div>

            <form method="POST" action="{{ route('customer.membership.store') }}" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                <input type="hidden" name="kategori" value="{{ $kategori_utama }}">
                <input type="hidden" name="sub_kategori" id="hidden_sub_kategori">
                
                <div class="space-y-6">
                    <!-- Data Pemesan -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 mb-4">Data Pemesan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" :value="Auth::user()->customer->nama ?? Auth::user()->name" readonly />
                            </div>
                            <div>
                                <x-input-label for="no_telp" :value="__('No. Telepon')" />
                                <x-text-input id="no_telp" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" :value="Auth::user()->customer->no_telp ?? ''" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Detail Reservasi -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 mb-4">Detail Reservasi</h3>
                        <div class="space-y-6">
                            
                            <!-- Dropdown Jenis Paket -->
                            <div>
                                <x-input-label for="sub_kategori_select" :value="__('Pilih Jenis Paket')" />
                                <select id="sub_kategori_select" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    @if ($kategori_utama == 'Gym')
                                        <option value="Privat">Privat</option>
                                        <option value="Harian">Harian</option>
                                        <option value="Bulanan">Bulanan</option>
                                    @else
                                        <option value="Privat">Privat</option>
                                        <option value="Reguler">Reguler</option>
                                        <option value="Insidental">Insidental</option>
                                    @endif
                                </select>
                            </div>
                            
                            <!-- Dropdown untuk memilih PAKET SPESIFIK (Awalnya tersembunyi) -->
                            <div id="field-paket" style="display: none;">
                                <x-input-label for="paket_id" :value="__('Pilih Detail Paket')" />
                                <select name="paket_id" id="paket_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    {{-- Opsi akan diisi oleh JavaScript --}}
                                </select>
                            </div>

                            <!-- Field Pelatih (Awalnya tersembunyi) -->
                            <div id="field-pelatih" style="display: none;">
                                <x-input-label for="pelatih_id" :value="__('Pilih Pelatih')" />
                                <select name="pelatih_id" id="pelatih_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    {{-- Opsi akan diisi oleh JavaScript --}}
                                </select>
                            </div>
                            
                            <!-- Field Tanggal -->
                            <div id="field-tanggal-rentang" style="display: none;" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><x-input-label for="tgl_mulai" :value="__('Tanggal Mulai')" /><x-text-input type="date" name="tgl_mulai" class="block w-full mt-1"/></div>
                                <div><x-input-label for="tgl_selesai" :value="__('Tanggal Selesai')" /><x-text-input type="date" name="tgl_selesai" class="block w-full mt-1"/></div>
                            </div>
                            <div id="field-tanggal-tunggal" style="display: none;">
                                <x-input-label for="tgl_datang" id="label_tgl_datang" :value="__('Tanggal Kedatangan')" />
                                <x-text-input type="date" name="tgl_datang" class="block w-full mt-1"/>
                            </div>

                            <!-- Penampil Harga -->
                            <div id="display-harga" style="display: none;" class="mt-4 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg"><p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Harga</p><p id="harga-teks" class="text-2xl font-bold text-gray-900 dark:text-white"></p>
                                <p id="harga-teks" class="text-2xl font-bold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>
                    </div>
                    <div id="info-transfer" style="display: none;" class="mt-2 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                        <p class="text-sm text-gray-700 dark:text-yellow-100">
                            Silakan lakukan pembayaran transfer ke <strong>Bank BCA 5220304xxx A.n Body Zone</strong>.
                        </p>
                    </div>

                    <!-- Pembayaran -->
                     <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 mb-4">Pembayaran</h3>
                         <div>
                            <x-input-label for="bukti_bayar" :value="__('Upload Bukti Pembayaran')" />
                            <input type="file" name="bukti_bayar" id="bukti_bayar" class="block w-full mt-1 text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50" required>
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, PDF</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                    <x-primary-button>{{ __('Kirim Reservasi') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
   <script>
document.addEventListener('DOMContentLoaded', function () {
    // === SELEKSI ELEMEN DOM ===
    const subKategoriSelect = document.getElementById('sub_kategori_select');
    const paketField = document.getElementById('field-paket');
    const paketSelect = document.getElementById('paket_id');
    // ... (elemen lainnya tetap sama)
    const pelatihField = document.getElementById('field-pelatih');
    const pelatihSelect = document.getElementById('pelatih_id');
    const tglRentangField = document.getElementById('field-tanggal-rentang');
    const tglTunggalField = document.getElementById('field-tanggal-tunggal');
    const labelTglTunggal = document.getElementById('label_tgl_datang');
    const displayHarga = document.getElementById('display-harga');
    const hargaTeks = document.getElementById('harga-teks');
    const hiddenSubKategori = document.getElementById('hidden_sub_kategori');
    
    // === DATA DARI SERVER (BLADE) ===
    const semuaPaket = @json($paket);
    const semuaPelatih = @json($pelatih);

    // LANGKAH DEBUG 1: Cek data awal di console browser
    console.log('Data Paket dari Server:', semuaPaket);

    // === FUNGSI BANTU ===
    function formatRupiah(angka) {
        // Pengecekan jika angka tidak valid
        if (isNaN(angka) || angka === null) return "Rp 0";
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    // === EVENT LISTENER: PERUBAHAN JENIS PAKET ===
    subKategoriSelect.addEventListener('change', function() {
        const subKategori = this.value;
        hiddenSubKategori.value = subKategori;

        // Reset semua field turunan
        paketField.style.display = 'none';
        pelatihField.style.display = 'none';
        tglRentangField.style.display = 'none';
        tglTunggalField.style.display = 'none';
        displayHarga.style.display = 'none';
        paketSelect.innerHTML = '<option value="">-- Pilih --</option>';
        pelatihSelect.innerHTML = '<option value="">-- Pilih Pelatih --</option>';

        if (!subKategori) return;
        
        paketField.style.display = 'block';

        // LANGKAH DEBUG 2: Cek jenis paket yang dipilih
        console.log('Jenis Paket dipilih:', subKategori);

        // --- FILTER LOGIKA YANG LEBIH AMAN ---
        const paketTersedia = semuaPaket.filter(p => {
            // Pastikan p dan p.nama tidak null untuk menghindari error
            if (!p || !p.nama) return false;

            const namaPaket = p.nama.toLowerCase();
            const jenisPaket = subKategori.toLowerCase();

            // Prioritas 1: Cek via 'sub_kategori' (Cara Terbaik & Akurat)
            if (p.sub_kategori) {
                return p.sub_kategori.toLowerCase() === jenisPaket;
            }

            // Prioritas 2: Fallback dengan cek 'nama' paket (Jika 'sub_kategori' tidak ada)
            // Ini adalah logika yang diperbaiki untuk kasus 'Bulanan' vs 'Bulan'
            if (jenisPaket === 'bulanan') {
                return namaPaket.includes('bulan'); 
            }
            
            // Untuk jenis lain seperti 'Harian', 'Privat', dll.
            return namaPaket.includes(jenisPaket);
        });

        // LANGKAH DEBUG 3: Cek hasil filter
        console.log('Paket yang cocok setelah difilter:', paketTersedia);

        // Kosongkan opsi sebelum mengisi
        paketSelect.innerHTML = '<option value="">-- Pilih Detail Paket --</option>'; 
        
        if (paketTersedia.length > 0) {
            paketTersedia.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = `${p.nama}`; 
                option.dataset.harga = p.harga;
                paketSelect.appendChild(option);
            });
        } else {
            // Beri tahu pengguna jika tidak ada paket yang ditemukan
            paketSelect.innerHTML = '<option value="">-- Tidak ada paket tersedia --</option>'; 
            console.warn('Tidak ada paket yang ditemukan untuk jenis:', subKategori);
        }

        if (paketTersedia.length === 1) {
            paketSelect.value = paketTersedia[0].id;
            paketSelect.dispatchEvent(new Event('change'));
        }
    });

    // Event listener untuk 'paketSelect' tidak perlu diubah, biarkan seperti sebelumnya.
    paketSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const paketId = selectedOption.value;

        pelatihField.style.display = 'none';
        tglRentangField.style.display = 'none';
        tglTunggalField.style.display = 'none';
        displayHarga.style.display = 'none';
        pelatihSelect.innerHTML = '<option value="">-- Pilih Pelatih --</option>';

        if (!paketId) return;

        const harga = selectedOption.dataset.harga;
        const paketNama = selectedOption.text.split('(')[0].trim().toLowerCase();

        hargaTeks.textContent = formatRupiah(harga);
        displayHarga.style.display = 'block';
        document.getElementById("info-transfer").style.display = "block";

        if (paketNama.includes('privat') || paketNama.includes('insidental')) {
            pelatihField.style.display = 'block';
            const pelatihTersedia = semuaPelatih.filter(p => p.paket_id == paketId); 
            pelatihTersedia.forEach(pelatih => {
                const option = document.createElement('option');
                option.value = pelatih.id;
                option.textContent = pelatih.nama;
                pelatihSelect.appendChild(option);
            });
        }
        
        if (paketNama.includes('reguler') || paketNama.includes('bulan')) {
            tglRentangField.style.display = 'grid';
        } else if (paketNama.includes('harian') || paketNama.includes('insidental')) {
            const kategoriUtama = "{{ $kategori_utama }}";
            labelTglTunggal.textContent = `Tanggal ${kategoriUtama}`;
            tglTunggalField.style.display = 'block';
        }
    });
});
</script>
    @endpush
</x-app-layout>
