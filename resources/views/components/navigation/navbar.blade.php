<header class="bg-[#2A1B60] text-white sticky top-0 z-50 shadow-md"
        x-data="{ mobileMenuOpen: false, openPengguna: false, openProfile: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo & Brand (EKSIS) - Clickable, menuju ke index sesuai role -->
            @if(request()->is('siswa*'))
                <a href="{{ route('siswa.home') }}" class="flex items-center gap-3">
                    <img src="/images/logo-sman2.png" alt="Logo SMAN 2 Bangkalan" class="h-10 w-auto object-contain" onerror="this.src='https://placehold.co/100x100?text=SMAN2'">
                    <span class="text-lg font-bold tracking-wider">EKSIS</span>
                </a>
            @elseif(request()->is('ketua*'))
                <a href="{{ route('ketua.dashboard') }}" class="flex items-center gap-3">
                    <img src="/images/logo-sman2.png" alt="Logo SMAN 2 Bangkalan" class="h-10 w-auto object-contain" onerror="this.src='https://placehold.co/100x100?text=SMAN2'">
                    <span class="text-lg font-bold tracking-wider">EKSIS</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="/images/logo-sman2.png" alt="Logo SMAN 2 Bangkalan" class="h-10 w-auto object-contain" onerror="this.src='https://placehold.co/100x100?text=SMAN2'">
                    <span class="text-lg font-bold tracking-wider">EKSIS</span>
                </a>
            @endif

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-normal">
                @if(request()->is('siswa*'))
                    <!-- Student Menu Items -->
                    <a href="{{ route('siswa.home') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('siswa.home') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Home
                    </a>
                    <a href="{{ request()->routeIs('siswa.home') ? '#manfaat' : route('siswa.home') . '#manfaat' }}"
                       class="transition-colors duration-200 text-gray-300 hover:text-white">
                        About
                    </a>
                    <a href="{{ route('siswa.ekskul.index') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('siswa.ekskul.index') || request()->routeIs('siswa.ekskul.show') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Ekstrakurikuler
                    </a>
                    <a href="{{ route('siswa.rekomendasi.create') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('siswa.rekomendasi.create') || request()->routeIs('siswa.rekomendasi.results') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Rekom Ekskul
                    </a>
                    <a href="{{ route('siswa.register.history') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('siswa.register.history') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Riwayat Daftar
                    </a>
                @elseif(request()->is('ketua*'))
                    <!-- Ketua Menu Items -->
                    <a href="{{ route('ketua.dashboard') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('ketua.dashboard') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('ketua.pendaftaran.index') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('ketua.pendaftaran.index') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Pendaftaran
                    </a>
                    <a href="{{ route('ketua.anggota.index') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('ketua.anggota.index') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Data Anggota
                    </a>
                    <a href="{{ route('ketua.absensi.index') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('ketua.absensi.index') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Data Absensi
                    </a>
                @else
                    <!-- Admin Menu Items -->
                    <!-- Dashboard (Active) -->
                    <a href="{{ route('dashboard') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Dashboard
                    </a>

                    <!-- Data Ekstrakurikuler -->
                    <a href="{{ route('ekskul.index') }}"
                       class="transition-colors duration-200 {{ request()->routeIs('ekskul.index') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white' }}">
                        Data Ekstrakurikuler
                    </a>

                    <!-- Dropdown Data Pengguna -->
                    <div class="relative" @click.away="openPengguna = false">
                        <button @click="openPengguna = !openPengguna; openProfile = false"
                                @keydown.escape="openPengguna = false"
                                class="flex items-center gap-1.5 text-gray-300 hover:text-white transition-colors duration-200 focus:outline-none cursor-pointer"
                                :class="openPengguna ? 'text-white font-medium' : ''"
                                aria-haspopup="true"
                                :aria-expanded="openPengguna">
                            <span>Data Pengguna</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openPengguna ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div x-show="openPengguna"
                             class="absolute left-0 mt-3 w-48 rounded-xl bg-white text-gray-800 shadow-xl border border-[#f2eaea] py-2 z-50"
                             style="display: none;">
                            <a href="{{ route('pengguna.admin.index') }}" class="block px-4 py-2 hover:bg-brand-primary/10 hover:text-brand-primary transition-colors duration-150 text-sm">Admin</a>
                            <a href="{{ route('pengguna.ketua.index') }}" class="block px-4 py-2 hover:bg-brand-primary/10 hover:text-brand-primary transition-colors duration-150 text-sm">Ketua Ekskul</a>
                            <a href="{{ route('pengguna.siswa.index') }}" class="block px-4 py-2 hover:bg-brand-primary/10 hover:text-brand-primary transition-colors duration-150 text-sm">Siswa</a>
                        </div>
                    </div>
                @endif
            </nav>

            <!-- User Profile / Logout Action Button -->
            <div class="flex items-center gap-4">

                @if(request()->is('siswa*'))
                    <!-- Welcome greeting "Hi, [nama siswa]" -->
                    <span class="hidden md:inline text-sm font-semibold text-gray-200">
                        Hi, {{ Auth::user()->name }}
                    </span>
                    <!-- Student Yellow Logout Button matching screenshot -->
                    <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                        @csrf
                        <button type="submit" class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] font-semibold text-sm px-5 py-2.5 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm cursor-pointer">
                            <svg class="w-4 h-4 text-[#1F2937]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <!-- Desktop Admin User Profile -->
                    <div class="relative hidden md:block" @click.away="openProfile = false">
                        <button @click="openProfile = !openProfile; openPengguna = false"
                                @keydown.escape="openProfile = false"
                                class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition-colors duration-200 focus:outline-none cursor-pointer"
                                aria-haspopup="true"
                                :aria-expanded="openProfile">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-brand-primary overflow-hidden border border-white/50 shadow-sm transition-transform duration-200">
                                <svg class="w-5.5 h-5.5 text-[#2A1B60] mt-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <span class="font-normal">Hallo, {{ Auth::user()->name ?? 'Username' }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openProfile ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div x-show="openProfile"
                             class="absolute right-0 mt-3 w-48 rounded-xl bg-white text-gray-800 shadow-xl border border-[#f2eaea] py-2 z-50"
                             style="display: none;">
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 hover:bg-brand-primary/10 hover:text-brand-primary transition-colors duration-150 text-sm">Profil Saya</a>
                                @else
                                    <span class="block px-4 py-2 text-sm text-gray-400">Profil Saya</span>
                                @endif
                            @endauth
                            <hr class="border-gray-100 my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-150 cursor-pointer text-sm">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Hamburger Mobile Menu Toggle Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none transition-colors duration-200 cursor-pointer"
                        aria-label="Toggle mobile menu"
                        :aria-expanded="mobileMenuOpen">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="mobileMenuOpen ? 'hidden' : 'inline-flex'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="mobileMenuOpen ? 'inline-flex' : 'hidden'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden bg-[#2A1B60] border-t border-white/10 shadow-lg max-h-[calc(100vh-4rem)] overflow-y-auto"
         style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-3 text-sm">

            @if(request()->is('siswa*'))
                <!-- Student Mobile Menu Items -->
                <a href="{{ route('siswa.home') }}"
                   class="block py-2.5 px-3 rounded-lg text-white font-medium hover:bg-white/10 transition-colors duration-150">
                    Home
                </a>
                <a href="{{ request()->routeIs('siswa.home') ? '#manfaat' : route('siswa.home') . '#manfaat' }}"
                   class="block py-2.5 px-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-150">
                    About
                </a>
                <a href="{{ route('siswa.ekskul.index') }}"
                   class="block py-2.5 px-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-150">
                    Ekstrakurikuler
                </a>
                <a href="{{ route('siswa.rekomendasi.create') }}"
                   class="block py-2.5 px-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-150">
                    Rekom Ekskul
                </a>
                <a href="{{ route('siswa.register.history') }}"
                   class="block py-2.5 px-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-150">
                    Riwayat Daftar
                </a>
                <hr class="border-white/10 my-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-3 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors duration-150 cursor-pointer">
                        Logout
                    </button>
                </form>
            @elseif(request()->is('ketua*'))
                <!-- Ketua Mobile Menu Items -->
                <a href="{{ route('ketua.dashboard') }}"
                   class="block py-2.5 px-3 rounded-lg {{ request()->routeIs('ketua.dashboard') ? 'text-white font-medium bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} transition-colors duration-150">
                    Dashboard
                </a>
                <a href="{{ route('ketua.pendaftaran.index') }}"
                   class="block py-2.5 px-3 rounded-lg {{ request()->routeIs('ketua.pendaftaran.index') ? 'text-white font-medium bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} transition-colors duration-150">
                    Pendaftaran
                </a>
                <a href="{{ route('ketua.anggota.index') }}"
                   class="block py-2.5 px-3 rounded-lg {{ request()->routeIs('ketua.anggota.index') ? 'text-white font-medium bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} transition-colors duration-150">
                    Data Anggota
                </a>
                <a href="{{ route('ketua.absensi.index') }}"
                   class="block py-2.5 px-3 rounded-lg {{ request()->routeIs('ketua.absensi.index') ? 'text-white font-medium bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} transition-colors duration-150">
                    Data Absensi
                </a>

                <hr class="border-white/10 my-2">

                <!-- Ketua Mobile User Profile -->
                <div class="px-3 py-2 flex items-center gap-3 rounded-xl bg-white/5 border border-white/10">
                    <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-brand-primary overflow-hidden border border-white/50 shrink-0">
                        <svg class="w-6 h-6 text-[#2A1B60] mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="font-semibold text-white truncate">Hallo, {{ Auth::user()->name ?? 'Username' }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email ?? 'user@sman2bangkalan.sch.id' }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-3 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors duration-150 cursor-pointer">
                        Keluar
                    </button>
                </form>
            @else
                <!-- Admin Mobile Menu Items -->
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}"
                   class="block py-2.5 px-3 rounded-lg text-white font-medium hover:bg-white/10 transition-colors duration-150">
                    Dashboard
                </a>

                <!-- Data Ekstrakurikuler Link (Mobile) -->
                <a href="{{ route('ekskul.index') }}"
                   class="block py-2.5 px-3 rounded-lg {{ request()->routeIs('ekskul.index') ? 'text-white font-medium bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} transition-colors duration-150">
                    Data Ekstrakurikuler
                </a>

                <!-- Mobile Data Pengguna Dropdown -->
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between py-2.5 px-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-150 focus:outline-none">
                        <span>Data Pengguna</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 mt-1 space-y-1 bg-white/5 rounded-lg py-1">
                        <a href="{{ route('pengguna.admin.index') }}" class="block py-2 px-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-md">Admin</a>
                        <a href="{{ route('pengguna.ketua.index') }}" class="block py-2 px-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-md">Ketua Ekskul</a>
                        <a href="{{ route('pengguna.siswa.index') }}" class="block py-2 px-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-md">Siswa</a>
                    </div>
                </div>

                <hr class="border-white/10 my-2">

                <!-- Mobile User Profile -->
                <div class="px-3 py-2 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-brand-primary font-bold overflow-hidden border border-white/50">
                        <svg class="w-6 h-6 text-[#2A1B60] mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-white">Hallo, {{ Auth::user()->name ?? 'Username' }}</div>
                        <div class="text-xs text-gray-400">{{ Auth::user()->email ?? 'user@sman2bangkalan.sch.id' }}</div>
                    </div>
                </div>

                <a href="{{ route('admin.profile.edit') }}" class="block py-2.5 px-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-150">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-3 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors duration-150 cursor-pointer">
                        Keluar
                    </button>
                </form>
            @endif

        </div>
    </div>
</header>
