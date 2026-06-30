@extends('layouts.student')

@section('title', 'Pendaftaran Ekstrakurikuler SMAN 2 Bangkalan - EKSIS')

@section('content')
    <!-- 1. Hero Section with Interactive Slider (Frontend Only via AlpineJS) -->
    <section class="bg-[#2A1B60] text-white pt-16 pb-32 md:pt-20 md:pb-36 overflow-hidden relative"
             x-data="{ 
                activeSlide: 0, 
                slides: [
                    'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop'
                ],
                prev() { this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1 },
                next() { this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1 }
             }">
        <!-- Background School Glow -->
        <div class="absolute inset-0 bg-gradient-to-tr from-[#2A1B60] via-[#2A1B60]/95 to-[#3b258c] z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
            
            <!-- Left Side Text & Call to Actions -->
            <div class="w-full md:w-1/2 space-y-6">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-wide leading-tight text-white">
                    Pendaftaran Ekstrakurikuler <br>SMAN 2 Bangkalan
                </h1>
                <p class="text-sm sm:text-base text-gray-300 font-light leading-relaxed max-w-lg">
                    “Temukan versi terbaik dirimu! Lewat ekstrakurikuler, kamu bisa belajar hal baru, kenal banyak teman, dan jadi pribadi yang lebih keren. Coba Rekomendasi untuk pilihan sesuai preferensimu”
                </p>
                <div class="flex items-center gap-4 flex-wrap pt-2">
                    <x-ui.button 
                        onclick="window.location.href='{{ route('siswa.rekomendasi.create') }}'"
                        class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] px-8 py-3 rounded-full text-xs font-bold shadow-md transition-all duration-200 border-0 cursor-pointer"
                    >
                        Rekomendasi
                    </x-ui.button>
                    <a href="{{ route('siswa.ekskul.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-white hover:text-[#FDE047] transition-colors duration-150">
                        Cari Ekstrakurikuler
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Side Image Carousel with AlpineJS controls -->
            <div class="w-full md:w-1/2 flex items-center justify-center relative">
                <div class="relative w-full max-w-sm group">
                    <!-- Left Arrow button -->
                    <button @click="prev()" class="absolute -left-6 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 border border-white/20 w-10 h-10 rounded-full flex items-center justify-center text-white transition-all cursor-pointer z-20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    
                    <!-- Slider Container -->
                    <div class="aspect-[3/4] w-full rounded-[2.5rem] overflow-hidden bg-[#221550] p-1 border-2 border-white/10 shadow-2xl relative">
                        <div class="w-full h-full rounded-[2.3rem] overflow-hidden relative">
                            <!-- Gradient mesh border overlay -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-[#6366F1]/30 via-transparent to-[#FBCFE8]/25 z-10 pointer-events-none"></div>
                            
                            <!-- Images Loop (Interactive Slider) -->
                            <template x-for="(imgSrc, idx) in slides" :key="idx">
                                <img :src="imgSrc" 
                                     x-show="activeSlide === idx"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="w-full h-full object-cover absolute inset-0" 
                                     style="display: none;">
                            </template>
                        </div>
                    </div>

                    <!-- Right Arrow button -->
                    <button @click="next()" class="absolute -right-6 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 border border-white/20 w-10 h-10 rounded-full flex items-center justify-center text-white transition-all cursor-pointer z-20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- SVG Curve transition divider to content below -->
        <div class="absolute bottom-0 left-0 right-0 z-0 pointer-events-none">
            <svg class="w-full h-12 md:h-16 text-[#f3f4f6] fill-current" viewBox="0 0 1440 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,48C180,64 360,74 720,74C1080,74 1260,64 1440,48L1440,74L0,74Z"></path>
            </svg>
        </div>
    </section>

    <!-- 2. Manfaat Section (Latar Belakang Abu-Abu) -->
    <section class="bg-[#f3f4f6] pt-24 pb-28 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Title with underlined border like screens -->
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#2A1B60] tracking-wide inline-block relative pb-3">
                    Manfaat Mengikuti Ekstrakurikuler
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 h-1.5 w-32 bg-[#2A1B60]/20 rounded-full"></div>
                </h2>
            </div>

            <!-- Grid of 6 Benefits using shared benefit-card -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                
                <!-- Card 1 (Bohlam) -->
                <x-ui.benefit-card 
                    title="Mengembangkan Bakat dan Minat"
                    description="Ekskul memberikan wadah untuk mengasah dan menyalurkan hobi atau bakat yang mungkin tidak terakomodasi dalam kegiatan belajar mengajar di kelas."
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </x-slot>
                </x-ui.benefit-card>

                <!-- Card 2 (Keterampilan Sosial) -->
                <x-ui.benefit-card 
                    title="Membangun Keterampilan Sosial"
                    description="Dapat melatih kamu berinteraksi dengan orang lain, bekerja sama dalam tim, dan mengambil peran kepemimpinan."
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </x-slot>
                </x-ui.benefit-card>

                <!-- Card 3 (Topi Toga) -->
                <x-ui.benefit-card 
                    title="Meningkatkan Prestasi Akademik"
                    description="Dapat mengembangkan kedisiplinan, manajemen waktu, and juga ketekunan yang berdampak positif pada fokus belajar dan nilai akademik."
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.9c2.785 0 5.5-.068 8.006-.203a48.5 48.5 0 00-.49-6.347m-15.482 0a44.901 44.901 0 002.658-.883m-2.658.883l.007-.003M21.253 10.13c-.071-.32-.264-.619-.558-.778L12.07 5.103a.75.75 0 00-.693 0L3.3 9.352a.75.75 0 00-.23 1.059M21.253 10.13a44.9 44.9 0 01-2.658-.883m2.658.883l-.007-.003M3.07 9.865a.75.75 0 00-.23 1.059m0 0a48.674 48.674 0 003.546 5.86m0 0A48.3 48.3 0 0012 20.9M12 3v18" />
                        </svg>
                    </x-slot>
                </x-ui.benefit-card>

                <!-- Card 4 (Rantai) -->
                <x-ui.benefit-card 
                    title="Memperluas Jaringan dan Relasi"
                    description="Bertemu banyak teman baru dan memperluas pergaulan yang akan bermanfaat di masa depan."
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                    </x-slot>
                </x-ui.benefit-card>

                <!-- Card 5 (Grafik Naik) -->
                <x-ui.benefit-card 
                    title="Mengisi Waktu Luang dengan Produktif"
                    description="Ekskul adalah cara yang bagus untuk memanfaatkan waktu luang setelah sekolah, ini adalah kesempatan emas untuk menyalurkan energi secara positif."
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </x-slot>
                </x-ui.benefit-card>

                <!-- Card 6 (Folder Search) -->
                <x-ui.benefit-card 
                    title="Mempersiapkan Diri untuk Masa Depan"
                    description="Pengalaman dan keterampilan yang didapat menjadi bekal berharga yang akan memperkuat portofolio dan CV-mu."
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                </x-ui.benefit-card>

            </div>
        </div>

        <!-- Wave Curve transition divider to Section 3 below -->
        <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none">
            <svg class="w-full h-12 md:h-20 text-white fill-current" viewBox="0 0 1440 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,48C180,24 360,10 720,10C1080,10 1260,24 1440,48L1440,74L0,74Z"></path>
            </svg>
        </div>
    </section>

    <!-- 3. Profile Section (Latar Belakang Putih) -->
    <section class="bg-white pt-16 pb-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 max-w-6xl mx-auto">
                
                <!-- Left Image Mockup with colorful border -->
                <div class="w-full lg:w-2/5 flex items-center justify-center">
                    <div class="relative w-full max-w-[340px]">
                        <!-- Custom border design system matching school gate mockup -->
                        <div class="aspect-[4/5] w-full rounded-[2.5rem] overflow-hidden bg-white p-1.5 border-2 border-[#f2eaea] shadow-xl relative">
                            <div class="w-full h-full rounded-[2.3rem] overflow-hidden relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-[#6366F1]/20 via-transparent to-[#FBCFE8]/15 z-10 pointer-events-none"></div>
                                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop" 
                                     alt="SMAN 2 Bangkalan Building" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Profile Content -->
                <div class="w-full lg:w-3/5 space-y-6">
                    <h2 class="text-3xl font-bold text-[#2A1B60] tracking-tight">
                        Profile SMA Negeri 2 Bangkalan
                    </h2>
                    
                    <p class="text-sm text-gray-500 font-light leading-relaxed">
                        SMAN 2 Bangkalan adalah sekolah menengah atas negeri yang terletak di Jl. Soekarno Hatta No 18, Mlajah, Kec. Bangkalan, Kab. Bangkalan, Jawa Timur. Sekolah ini didirikan pada 1 April 1978 dan saat ini memiliki 1198 siswa yang dibimbing oleh 81 guru profesional. SMAN 2 Bangkalan terakreditasi A dengan nilai 90 dari BAN-S/M pada 25 Oktober 2016. Sekolah ini berkomitmen untuk mencerdaskan anak bangsa dan terus berinovasi dalam pendidikan.
                    </p>

                    <div class="pt-2">
                        <x-ui.button 
                            class="bg-[#FDE047] hover:bg-[#FACC15] text-[#1F2937] px-8 py-3 rounded-full text-xs font-bold shadow-md transition-all duration-200 border-0 cursor-pointer"
                        >
                            Selengkapnya
                        </x-ui.button>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
