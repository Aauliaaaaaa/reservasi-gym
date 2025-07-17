<x-app-layout>
     <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
             <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ubah Jadwal Reservasi</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $membership->paket->nama ?? $membership->sub_kategori }}</p>
            </div>

            <form action="{{ route('customer.reservasi.update', $membership->id) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                {{-- PERBAIKAN: Gunakan @if untuk menampilkan form yang sesuai --}}

                {{-- Untuk Paket Bulanan dan Reguler --}}
                @if(in_array($membership->sub_kategori, ['Bulanan', 'Reguler']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="tgl_mulai" :value="__('Tanggal Mulai Baru')" />
                            <x-text-input id="tgl_mulai" type="date" name="tgl_mulai" class="mt-1 block w-full" :value="$membership->tgl_mulai" required />
                            <x-input-error :messages="$errors->get('tgl_mulai')" class="mt-2" />
                        </div>
                         <div>
                            <x-input-label for="tgl_selesai" :value="__('Tanggal Selesai Baru')" />
                            <x-text-input id="tgl_selesai" type="date" name="tgl_selesai" class="mt-1 block w-full" :value="$membership->tgl_selesai" required />
                            <x-input-error :messages="$errors->get('tgl_selesai')" class="mt-2" />
                        </div>
                    </div>
                {{-- Untuk Paket Harian dan Insidental --}}
                @elseif(in_array($membership->sub_kategori, ['Harian', 'Insidental']))
                    <div>
                        <x-input-label for="tgl_datang">
                            Pilih Tanggal Baru untuk {{ $membership->kategori }}
                        </x-input-label>
                        <x-text-input id="tgl_datang" type="date" name="tgl_datang" class="mt-1 block w-full" :value="$membership->tgl_datang" required />
                        <x-input-error :messages="$errors->get('tgl_datang')" class="mt-2" />
                    </div>
                @endif

                <div class="flex items-center justify-end mt-6 pt-6 border-t">
                    <a href="{{ route('customer.reservasi.index') }}" class="text-sm text-gray-600 underline mr-4">Batal</a>
                    <x-primary-button>
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
     </div>
</x-app-layout>
