<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Ubah Reservasi Membership {{ $membership->kategori }} - Private
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Silakan ubah detail reservasi Anda di bawah ini.
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

            <form method="POST" action="{{ route('customer.reservasi.edit.privat.update', $membership->id) }}" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                @method('PUT')
                <input type="hidden" name="kategori" value="{{ $membership->kategori }}">
                <input type="hidden" name="sub_kategori" value="Privat">
                
                <div class="space-y-6">
                    <!-- Data Pemesan -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 mb-4">Data Pemesan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" :value="$membership->customer->nama ?? Auth::user()->name" readonly />
                            </div>
                            <div>
                                <x-input-label for="no_telp" :value="__('No. Telepon')" />
                                <x-text-input id="no_telp" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" :value="$membership->customer->no_telp ?? ''" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Detail Reservasi -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 mb-4">Detail Reservasi</h3>
                        <div class="space-y-6">
                            
                            <!-- Jenis Paket (Read-only) -->
                            <div>
                                <x-input-label for="sub_kategori_display" :value="__('Jenis Paket')" />
                                <x-text-input id="sub_kategori_display" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" value="Private" readonly />
                            </div>
                            
                            <!-- Dropdown untuk memilih PAKET SPESIFIK -->
                            <div>
                                <x-input-label for="paket_id" :value="__('Pilih Detail Paket')" />
                                <select name="paket_id" id="paket_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Detail Paket --</option>
                                    @foreach($data['paket'] as $p)
                                        <option value="{{ $p->id }}" 
                                            data-harga="{{ $p->harga }}"
                                            {{ $membership->paket_id == $p->id ? 'selected' : 'disabled' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Field Pelatih -->
                            <div>
                                <x-input-label for="pelatih_id" :value="__('Pilih Pelatih')" />
                                <select name="pelatih_id" id="pelatih_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Pelatih --</option>
                                    @foreach($data['pelatih'] as $p)
                                        <option value="{{ $p->id }}" {{ $membership->pelatih_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Field Detail Booking Private -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Jadwal Pertemuan</h4>
                                <div class="flex flex-col gap-4">
                                    @for ($i = 1; $i <= 10; $i++)
                                        @php
                                            $membershipDetail = $membership->membershipDetails->get($i - 1);
                                        @endphp
                                        <div>
                                            <p class="font-semibold">Pertemuan {{ $i }}</p>
                                            <div class="grid grid-cols-3 gap-6">
                                                <div>
                                                    <x-input-label for="tgl_datang_{{ $i }}" :value="__('Tanggal Kedatangan')" />
                                                    <x-text-input type="date" 
                                                        name="tgl_datang_private[]" 
                                                        id="tgl_datang_{{ $i }}"
                                                        class="block w-full mt-1"
                                                        value="{{ $membershipDetail ? $membershipDetail->tgl_datang : '' }}" />
                                                </div>
                                                <div>
                                                    <x-input-label for="jam_mulai_{{ $i }}" :value="__('Jam Mulai')" />
                                                    <x-text-input type="time" 
                                                        name="jam_mulai_private[]" 
                                                        id="jam_mulai_{{ $i }}"
                                                        class="block w-full mt-1 jam-mulai"
                                                        value="{{ $membershipDetail ? $membershipDetail->jam_mulai : '' }}" />
                                                </div>
                                                <div>
                                                    <x-input-label for="jam_selesai_{{ $i }}" :value="__('Jam Selesai')" />
                                                    <x-text-input type="time" 
                                                        name="jam_selesai_private[]" 
                                                        id="jam_selesai_{{ $i }}"
                                                        class="block w-full mt-1 jam-selesai"
                                                        value="{{ $membershipDetail ? $membershipDetail->jam_selesai : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Penampil Harga -->
                            <div class="mt-4 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Harga</p>
                                <p id="harga-teks" class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ 'Rp ' . number_format($membership->paket->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('customer.reservasi.index') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                        {{ __('Kembali') }}
                    </a>
                    <x-primary-button>{{ __('Update Reservasi') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const paketSelect = document.getElementById('paket_id');
        const pelatihSelect = document.getElementById('pelatih_id');
        const hargaTeks = document.getElementById('harga-teks');
        
        // Data dari server
        const semuaPelatih = @json($data['pelatih']);
        console.log(semuaPelatih);
        // Format rupiah
        function formatRupiah(angka) {
            if (isNaN(angka) || angka === null) return "Rp 0";
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        // Update harga saat paket berubah
        paketSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const paketId = selectedOption.value;
            const harga = selectedOption.dataset.harga;

            // Update harga
            if (harga && hargaTeks) {
                hargaTeks.textContent = formatRupiah(harga);
            }

            // Update opsi pelatih berdasarkan paket yang dipilih
            pelatihSelect.innerHTML = '<option value="">-- Pilih Pelatih --</option>';
            
            if (paketId) {
                // Filter pelatih berdasarkan paket_id yang dipilih
                const pelatihTersedia = semuaPelatih.filter(p => p.paket_id == paketId);
                console.log('Pelatih tersedia untuk paket ID ' + paketId + ':', pelatihTersedia);
                
                pelatihTersedia.forEach(pelatih => {
                    const option = document.createElement('option');
                    option.value = pelatih.id;
                    option.textContent = pelatih.user.name;
                    
                    // Pertahankan pilihan pelatih yang sudah ada
                    if (pelatih.id == {{ $membership->pelatih_id ?? 'null' }}) {
                        option.selected = true;
                    }
                    
                    pelatihSelect.appendChild(option);
                });

                // Jika tidak ada pelatih untuk paket yang dipilih
                if (pelatihTersedia.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = '-- Tidak ada pelatih tersedia untuk paket ini --';
                    option.disabled = true;
                    pelatihSelect.appendChild(option);
                }
            }
        });

        // Auto calculate jam selesai
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('jam-mulai')) {
                const jamMulaiInput = e.target;
                const jamMulaiValue = jamMulaiInput.value;
                
                if (jamMulaiValue) {
                    // Find the corresponding jam_selesai input in the same row
                    const parentDiv = jamMulaiInput.closest('.grid');
                    const jamSelesaiInput = parentDiv.querySelector('.jam-selesai');
                    
                    if (jamSelesaiInput && !jamSelesaiInput.value) {
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
                        
                        jamSelesaiInput.value = jamSelesaiValue;
                    }
                }
            }
        });

        // Trigger change event untuk setup awal
        if (paketSelect.value) {
            paketSelect.dispatchEvent(new Event('change'));
        }
    });
    </script>
    @endpush
</x-app-layout>