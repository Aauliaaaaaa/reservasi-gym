<x-app-layout>
    {{-- Memuat library html2canvas dari CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-8">
        {{-- Beri ID unik pada elemen kartu agar bisa "difoto" oleh script --}}
        <div id="detail-reservasi-card" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Detail Pemesanan Body Zone Cilacap
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Tunjukkan halaman ini kepada admin di lokasi.
                </p>
            </div>
            
            <div class="p-6 md:p-8">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    {{-- Informasi Umum --}}
                    <div class="md:col-span-2"><dt class="font-medium text-gray-500">Tanggal Reservasi</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ $membership->created_at->format('d F Y, H:i') }}</dd></div>
                    <div class="md:col-span-2"><dt class="font-medium text-gray-500">Nama Customer</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ $membership->customer->nama }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Kategori Layanan</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ $membership->kategori }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Paket Dipilih</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ $membership->paket->nama ?? $membership->sub_kategori }}</dd></div>

                    {{-- Data spesifik berdasarkan sub_kategori --}}
                    @if(in_array($membership->sub_kategori, ['Privat', 'Insidental']))
                        <div class="md:col-span-2"><dt class="font-medium text-gray-500">Pelatih</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ $membership->pelatih->nama ?? 'Tidak ditentukan' }}</dd></div>
                    @endif
                    @if(in_array($membership->sub_kategori, ['Bulanan', 'Reguler']))
                        <div><dt class="font-medium text-gray-500">Tanggal Mulai</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($membership->tgl_mulai)->format('d F Y') }}</dd></div>
                        <div><dt class="font-medium text-gray-500">Tanggal Selesai</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($membership->tgl_selesai)->format('d F Y') }}</dd></div>
                    @endif
                    @if(in_array($membership->sub_kategori, ['Harian', 'Insidental']))
                         <div class="md:col-span-2"><dt class="font-medium text-gray-500">Tanggal Latihan</dt><dd class="mt-1 text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($membership->tgl_datang)->format('d F Y') }}</dd></div>
                    @endif

                    {{-- Informasi Pembayaran --}}
                    <div class="border-t pt-4 mt-2">
                        <dt class="font-medium text-gray-500">Harga</dt>
                        <dd class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">Rp {{ number_format($membership->paket->harga ?? 0) }}</dd>
                    </div>
                    
                     <div class="border-t pt-4 mt-2">
                        <dt class="font-medium text-gray-500">Status Pembayaran</dt>
                        <dd class="mt-1">
                            @if($membership->status == 'lunas')
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 dark:text-green-100">Lunas</span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 dark:text-red-100">Belum Lunas</span>
                            @endif
                        </dd>
                    </div>
                    {{-- <div class="md:col-span-2">
                        <dt class="font-medium text-gray-500">Bukti Pembayaran</dt>
                        <dd class="mt-1"><a href="{{ asset('storage/' . $membership->bukti_bayar) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti Bayar</a></dd>
                    </div> --}}
                </dl>
            </div>

            {{-- PERBAIKAN: Beri ID pada bagian tombol ini --}}
            <div id="action-buttons" class="p-6 md:p-8 border-t border-gray-200 flex justify-end gap-4">
                <a href="{{ route('customer.reservasi.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm font-medium">Kembali</a>
                <button id="download-button" type="button" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium">
                    Download Detail Pesanan
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Script untuk fungsionalitas download --}}
    <script>
        document.getElementById('download-button').addEventListener('click', function() {
            const cardElement = document.getElementById('detail-reservasi-card');
            // PERBAIKAN: Ambil elemen tombol untuk disembunyikan
            const actionButtons = document.getElementById('action-buttons');
            
            const options = { scale: 2, useCORS: true };

            // PERBAIKAN: Sembunyikan tombol sebelum mengambil gambar
            actionButtons.style.display = 'none';

            html2canvas(cardElement, options).then(canvas => {
                // Setelah selesai, tampilkan kembali tombolnya
                actionButtons.style.display = 'flex';

                const link = document.createElement('a');
                link.download = 'bukti-reservasi-bodyzone-{{ $membership->id }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    </script>
    @endpush
</x-app-layout>
