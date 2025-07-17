<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Body Zone</title>
        @vite(['resources/css/app.css', 'resources/js/app.js']) 

        <style>
            /* Menambahkan smooth scroll behavior */
            html {
                scroll-behavior: smooth;
            }
    
            /* Fix Navbar di atas */
            nav {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 50; /* Pastikan navbar di atas konten */
            }
    
            /* Menambahkan padding pada bagian konten agar tidak tertutup navbar */
            body {
                padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
            }
        </style>
    </head>
    <body class="bg-gray-100 text-gray-800 scroll-smooth">

        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="text-xl font-bold text-yellow-600">Body Zone</div>
                    <div class="space-x-4">
                        <a href="#beranda" class="text-gray-700 hover:text-yellow-600">Beranda</a>
                        <a href="#sk" class="text-gray-700 hover:text-yellow-600">Syarat dan Ketentuan</a>
                        <a href="#fasilitas" class="text-gray-700 hover:text-yellow-600">Fasilitas</a>
                        <a href="#harga" class="text-gray-700 hover:text-yellow-600">Daftar Harga</a>
                    </div>
                </div>
            </div>
        </nav>

       <!-- Hero Section -->
        <section id="beranda" class="bg-green-50 py-20">
            <div class="max-w-4xl mx-auto text-center px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di Body Zone</h1>
                <p class="text-lg text-gray-600 mb-6">Solusi kebugaran untuk masa depan yang lebih sehat. Mulailah langkahmu hari ini!</p>

                @guest
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 text-white bg-yellow-600 hover:bg-yellow-700 font-medium rounded-lg text-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 text-yellow-600 border border-yellow-600 hover:bg-green-100 font-medium rounded-lg text-sm">
                            Daftar Sekarang
                        </a>
                    </div>
                @endguest
            </div>
        </section>
     

        <!-- Syarat dan Ketentuan Gym -->
        @include('syaratketentuan.syarat')

        <!-- Fasilitas Gym -->
        @include('fasilitas.fasilitas')

        <!-- Price List -->
        @include('paket.paket')


        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6 mt-20">
            <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
                &copy; 2025 Body Zone. All rights reserved.
            </div>
        </footer>

        <!-- Scroll to Top Button -->
        <button id="scrollToTopBtn" class="fixed bottom-6 right-6 bg-yellow-600 text-white p-3 rounded-full shadow-lg hover:bg-yellow-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7-7-7 7"></path>
            </svg>
        </button>

        <!-- Flowbite JS (pastikan diletakkan di akhir body) -->
        <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
         <!-- JavaScript untuk scroll to top button -->
        <script>
            // Ambil elemen tombol
            const scrollToTopBtn = document.getElementById('scrollToTopBtn');

            // Tampilkan tombol ketika halaman digulir lebih dari 300px
            window.onscroll = function () {
                if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                    scrollToTopBtn.style.display = "block";
                } else {
                    scrollToTopBtn.style.display = "none";
                }
            };

            // Ketika tombol diklik, scroll ke atas halaman
            scrollToTopBtn.onclick = function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };
        </script>
    </body>
</html>
