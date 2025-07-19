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

            <!-- Validation Errors Alert -->
            <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border-l-4 border-red-600 dark:border-red-500 rounded-md">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <h3 class="text-sm font-medium text-red-700 dark:text-red-300">Maaf:</h3>
                        </div>
                        <ul class="list-disc pl-5 space-y-1 text-sm text-red-600 dark:text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border-l-4 border-green-600 dark:border-green-500 rounded-md">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
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
                            
                            <div id="hint-booking-insidental" style="display: none;">
                                <div class="mt-4 border p-2 rounded-lg border-blue-500 dark:border-blue-600 bg-blue-100">
                                    <p class="text-sm font-semibold text-blue-500 dark:text-gray-400">
                                        <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Jam latihan: 16.00 - 18.00 WIB
                                    </p>
                                </div>
                            </div>

                            {{-- Field Detail Booking --}}
                            <div id="field-booking-private" style="display: none">
                                <div class="flex flex-col gap-4">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <div>
                                            <p class="font-semibold">Pertemuan {{ $i }}</p>
                                            <div class="grid grid-cols-3 gap-6">
                                                <div>
                                                    <x-input-label for="tgl_datang" id="label_tgl_datang" :value="__('Tanggal Kedatangan')" />
                                                    <x-text-input type="date" name="tgl_datang_private[]" class="block w-full mt-1"/>
                                                </div>
                                                <div>
                                                    <x-input-label for="jam_mulai" id="label_jam_mulai" :value="__('Jam Mulai')" />
                                                    <x-text-input type="time" name="jam_mulai_private[]" class="block w-full mt-1 jam-mulai"/>
                                                </div>
                                                <div>
                                                    <x-input-label for="jam_selesai" id="label_jam_selesai" :value="__('Jam Selesai')" />
                                                    <x-text-input type="time" name="jam_selesai_private[]" class="block w-full mt-1 jam-selesai" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
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
    const fieldBookingPrivate = document.getElementById('field-booking-private');
    const hintBookingInsidental = document.getElementById('hint-booking-insidental');
    
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
        fieldBookingPrivate.style.display = 'none';
        hintBookingInsidental.style.display = 'none';
        pelatihSelect.innerHTML = '<option value="">-- Pilih Pelatih --</option>';

        if (!paketId) return;

        const harga = selectedOption.dataset.harga;
        const paketNama = selectedOption.text.split('(')[0].trim().toLowerCase();

        hargaTeks.textContent = formatRupiah(harga);
        displayHarga.style.display = 'block';
        document.getElementById("info-transfer").style.display = "block";

        if (paketNama.includes('privat')) {
            fieldBookingPrivate.style.display = 'block';
        } else {
            fieldBookingPrivate.style.display = 'none';
        }

        if (paketNama.includes('insidental')) {
            hintBookingInsidental.style.display = 'block';
        } else {
            hintBookingInsidental.style.display = 'none';
        }

        if (paketNama.includes('privat') || paketNama.includes('insidental')) {
            pelatihField.style.display = 'block';
            const pelatihTersedia = semuaPelatih.filter(p => p.paket_id == paketId); 
            pelatihTersedia.forEach(pelatih => {
                const option = document.createElement('option');
                option.value = pelatih.id;
                option.textContent = pelatih.user.name;
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

    // === EVENT LISTENER: AUTO CALCULATE JAM SELESAI ===
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('jam-mulai')) {
            const jamMulaiInput = e.target;
            const jamMulaiValue = jamMulaiInput.value;
            
            if (jamMulaiValue) {
                // Find the corresponding jam_selesai input in the same row
                const parentDiv = jamMulaiInput.closest('.grid');
                const jamSelesaiInput = parentDiv.querySelector('.jam-selesai');
                
                if (jamSelesaiInput) {
                    // Calculate one hour later
                    const [hours, minutes] = jamMulaiValue.split(':');
                    const startTime = new Date();
                    startTime.setHours(parseInt(hours), parseInt(minutes), 0);
                    
                    // Add one hour
                    startTime.setHours(startTime.getHours() + 1);
                    
                    // Format back to HH:MM
                    const endHours = startTime.getHours().toString().padStart(2, '0');
                    const endMinutes = startTime.getMinutes().toString().padStart(2, '0');
                    const jamSelesaiValue = `${endHours}:${endMinutes}`;
                    
                    // Set the value and enable the input
                    jamSelesaiInput.value = jamSelesaiValue;
                    jamSelesaiInput.disabled = false;
                }
            }
        }
    });
});
</script>
    @endpush
</x-app-layout>
