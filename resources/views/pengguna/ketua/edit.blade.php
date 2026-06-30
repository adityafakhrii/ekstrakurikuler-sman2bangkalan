@extends('layouts.app')

@section('title', 'Edit Ketua - EKSIS SMAN 2 Bangkalan')

@section('content')
    <!-- Main Card Wrapper -->
    <x-ui.card title="Edit Ketua Baru">
        
        <!-- Dummy data definitions (Matches Ketua context) -->
        @php
            $ketua = [
                'name' => 'Pramuka',
                'pembina' => 'Ahmad Jihaduddin Salim',
                'description' => 'Pramuka adalah kegiatan ekstrakurikuler yang melatih kemandirian, disiplin, kerja sama, dan kepemimpinan melalui aktivitas seru seperti baris-berbaris, tali-temali, dan perkemahan.',
                'logo_filename' => 'Logo.jpg*'
            ];
        @endphp

        <!-- Edit Form -->
        <form method="POST" action="{{ route('pengguna.ketua.update', 1) }}" enctype="multipart/form-data" class="max-w-4xl mx-auto space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Informasi Umum -->
            <div>
                <x-ui.section-title title="Bagian 1: Informasi Umum" />
                <x-forms.ekskul-fields 
                    :name="$ketua['name']" 
                    :pembina="$ketua['pembina']" 
                    :description="$ketua['description']" 
                    :logo-filename="$ketua['logo_filename']" 
                />
            </div>

            <!-- Action Buttons (Right Aligned matching screenshot) -->
            <div class="flex justify-end gap-3 pt-6 border-t border-[#f2eaea]">
                <!-- Simpan Perubahan Button -->
                <x-ui.button type="submit" class="bg-[#6366F1] hover:bg-[#4F46E5] text-white py-2.5 px-6 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm">
                    <!-- Save/Disk Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Perubahan
                </x-ui.button>

                <!-- Batal Button (Grey) -->
                <x-ui.button variant="secondary" type="button" onclick="window.location.href='{{ route('pengguna.ketua.index') }}'" class="text-xs font-semibold py-2.5 px-6 rounded-lg shadow-sm">
                    Batal
                </x-ui.button>
            </div>

        </form>

    </x-ui.card>
@endsection
