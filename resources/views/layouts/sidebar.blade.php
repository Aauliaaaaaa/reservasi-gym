{{-- Asumsikan ini adalah bagian dari layout utama atau komponen sidebar --}}

{{-- @auth
    @if(auth()->user()->role === 'admin') --}}

    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-white-800" >
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">BODY ZONE</h1>
            </div>
            <ul class="space-y-2 font-medium">
               

                {{-- Admin Roles --}}
                @hasrole('admin')
                     <li>
                        {{-- Dashboard --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        {{-- Customer --}}
                        <a href="{{ route('customer.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('customer.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('customer.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a4 4 0 1 0 4 4 4 4 0 0 0-4-4ZM10 4a2 2 0 1 1-2 2 2 2 0 0 1 2-2ZM6 12a4 4 0 0 1 8 0v4H6v-4Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Customer</span>
                        </a>
                    </li>
                    <li>
                        {{-- Memberships Dropdown --}}
                        <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700
                            {{ request()->routeIs('membership.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : '' }}"
                            aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('membership.*') ? 'text-blue-600 dark:text-white' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                                <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Memberships</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-example" class="py-2 space-y-2 {{ request()->routeIs('membership.*') ? 'block' : 'hidden' }}">
                            <li>
                                <a href="{{ route('membership.gym', ['kategori' => 'Privat']) }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                    {{ request()->routeIs('membership.gym') && request('kategori') == 'Privat' ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Gym</a>
                            </li>
                             <li>
                              <a href="{{ route('membership.boxing', ['kategori' => 'Privat']) }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                 {{ request()->routeIs('membership.boxing') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Boxing</a>
                           </li>
                           <li>
                              <a href="{{ route('membership.muaythai', ['kategori' => 'Privat']) }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                 {{ request()->routeIs('membership.muaythai') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Muay Thai</a>
                           </li>
                        </ul>
                    </li>
                    <li>
                        {{-- Syarat dan Ketentuan --}}
                        <a href="{{ route('syarat.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('syarat.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('syarat.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Syarat dan Ketentuan</span>
                        </a>
                    </li>
                    <li>
                        {{-- Fasilitas --}}
                        <a href="{{ route('fasilitas.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('fasilitas.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('fasilitas.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Fasilitas</span>
                        </a>
                    </li>
                    <li>
                        {{-- Paket Harga --}}
                        <a href="{{ route('paket.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('paket.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Paket Harga</span>
                        </a>
                    </li>
                    <li>
                        {{-- Pelatih --}}
                        {{-- <a href="{{ route('pelatih.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('pelatih.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('pelatih.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pelatih</span>
                        </a> --}}

                        <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700
                            {{ request()->routeIs('pelatih.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : '' }}"
                            aria-controls="dropdown-pelatih" data-collapse-toggle="dropdown-pelatih">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('pelatih.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pelatih</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-pelatih" class="py-2 space-y-2 {{ request()->routeIs('pelatih.*') ? 'block' : 'hidden' }}">
                            <li>
                                <a href="{{ route('pelatih.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                    {{ request()->routeIs('pelatih.index') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Kelola Pelatih</a>
                            </li>
                             <li>
                              <a href="{{ route('pelatih.kelola_akun') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                 {{ request()->routeIs('pelatih.kelola_akun') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Akun Pelatih</a>
                           </li>
                        </ul>
                    </li>
                @endhasrole
                    
                @hasrole('owner')
                     <li>
                        {{-- Dashboard --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                     <li>
                        {{-- Customer --}}
                        <a href="{{ route('owner.customer.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('owner.customer.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('owner.customer.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a4 4 0 1 0 4 4 4 4 0 0 0-4-4ZM10 4a2 2 0 1 1-2 2 2 2 0 0 1 2-2ZM6 12a4 4 0 0 1 8 0v4H6v-4Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Data Customer</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('owner.membership.report') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('owner.membership.report') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('owner.membership.report') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.25,2.75H5.875a.5.5,0,0,0-.5.5v13.5a.5.5,0,0,0,.5.5h8.25a.5.5,0,0,0,.5-.5V7.875a.5.5,0,0,0-.146-.354l-4.25-4.25A.5.5,0,0,0,9.25,2.75Zm.125,5.5a.5.5,0,0,1-.5-.5V4.116L12.509,7.75H9.875A.5.5,0,0,1,9.375,8.25Z"/>
                            </svg>
                            
                            <span class="flex-1 ms-3 whitespace-nowrap">Data Membership</span>
                        </a>
                    </li>
                     <li>
                        <a href="{{ route('owner.laporan.tahunan') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('owner.laporan.tahunan') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('owner.laporan.tahunan') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.25,2.75H5.875a.5.5,0,0,0-.5.5v13.5a.5.5,0,0,0,.5.5h8.25a.5.5,0,0,0,.5-.5V7.875a.5.5,0,0,0-.146-.354l-4.25-4.25A.5.5,0,0,0,9.25,2.75Zm.125,5.5a.5.5,0,0,1-.5-.5V4.116L12.509,7.75H9.875A.5.5,0,0,1,9.375,8.25Z"/>
                            </svg>
                            
                            <span class="flex-1 ms-3 whitespace-nowrap">Laporan Tahunan</span>
                        </a>
                    </li>
                @endhasrole
                
                {{-- Guest / Unauthenticated users --}}
                @guest
                    <li>
                        <a href="{{ route('login') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
                            {{ request()->routeIs('login') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Sign In</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
                            {{ request()->routeIs('register') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                                <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                                <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Sign Up</span>
                        </a>
                    </li>
                @endguest

                {{-- Customer Roles --}}
                @hasrole('customer')
                     <li>
                        {{-- Dashboard --}}
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('customer.dashboard') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('customer.dashboard') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.biodata') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('customer.biodata') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('customer.biodata') ? 'text-blue-600 dark:text-white' : '' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a5 5 0 1 0 0 10A5 5 0 0 0 10 2Zm0 12c-3.33 0-6 1.34-6 3v1h12v-1c0-1.66-2.67-3-6-3Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Biodata</span>
                        </a>
                    </li>
                   <li>
                        <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700
                            {{ request()->routeIs('customer.membership.*') ? 'bg-gray-100 dark:bg-gray-700' : 'text-gray-900' }}" 
                            aria-controls="dropdown-customer-membership" data-collapse-toggle="dropdown-customer-membership">
                            
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21"><path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/></svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Memberships</span>
                            <svg class="w-3 h-3 transform {{ request()->routeIs('customer.membership.*') ? 'rotate-180' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-customer-membership" class="{{ request()->routeIs('customer.membership.*') ? '' : 'hidden' }} py-2 space-y-2">
                            <li>
                                <a href="{{ route('customer.membership.gym.create') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                    {{ request()->routeIs('customer.membership.gym.create') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Gym</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.membership.muaythai.create') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                    {{ request()->routeIs('customer.membership.muaythai.create') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Muay Thai</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.membership.boxing.create') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                    {{ request()->routeIs('customer.membership.boxing.create') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Boxing</a>
                            </li>
                        </ul>
                    </li>
                   <li>
                        <a href="{{ route('customer.reservasi.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('customer.reservasi.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('customer.reservasi.*') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/><path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/><path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Bukti Reservasi</span>
                        </a>
                    </li>
                @endhasrole

                {{-- Customer Roles --}}
                @hasrole('pelatih')
                     <li>
                        {{-- Dashboard --}}
                        <a href="{{ route('trainer.dashboard.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('trainer.dashboard.index') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                                {{ request()->routeIs('trainer.dashboard.index') ? 'text-blue-600 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('trainer.booking.index') }}" class="flex items-center p-2 rounded-lg group
                            {{ request()->routeIs('trainer.booking.*') ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white
                                {{ request()->routeIs('trainer.booking.*') ? 'text-blue-600 dark:text-white' : '' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a5 5 0 1 0 0 10A5 5 0 0 0 10 2Zm0 12c-3.33 0-6 1.34-6 3v1h12v-1c0-1.66-2.67-3-6-3Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Booking</span>
                        </a>
                    </li>
                @endhasrole
            </ul>
        </div>
    </aside>