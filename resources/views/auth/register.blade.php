<x-guest-layout>
    {{-- Hapus <form> yang lama dan ganti dengan struktur baru ini --}}
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Header Form -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                BODY ZONE
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Buat akun baru untuk memulai.
            </p>
        </div>

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="nama" :value="__('Nama Lengkap')" />
            <div class="mt-1">
                <x-text-input id="nama" class="block w-full" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
            </div>
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>
        
        <!-- Grid untuk Jenis Kelamin dan No. Telepon -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Jenis Kelamin -->
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" @if(old('jenis_kelamin') == 'Laki-laki') selected @endif>Laki-laki</option>
                    <option value="Perempuan" @if(old('jenis_kelamin') == 'Perempuan') selected @endif>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
            </div>

            <!-- No. Telepon -->
            <div>
                <x-input-label for="no_telp" :value="__('No. Telepon')" />
                <div class="mt-1">
                    <x-text-input id="no_telp" class="block w-full" type="text" name="no_telp" :value="old('no_telp')" required autocomplete="tel" placeholder="Contoh: 08123456789" />
                </div>
                <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
            </div>
        </div>

        <!-- Alamat -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <div class="mt-1">
                <textarea id="alamat" name="alamat" rows="3" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required autocomplete="street-address" placeholder="Masukkan alamat lengkap Anda">{{ old('alamat') }}</textarea>
            </div>
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="mt-1">
                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="mt-1">
                <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="mt-1">
                <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password Anda" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-col items-center space-y-4 pt-4">
             <x-primary-button class="w-full justify-center text-lg">
                {{ __('Register') }}
            </x-primary-button>
            
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun? Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
