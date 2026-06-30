@if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-5 py-4 rounded-2xl mb-6 font-medium shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error') || $errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-5 py-4 rounded-2xl mb-6 font-medium shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('error') ?? $errors->first() }}</span>
    </div>
@endif
