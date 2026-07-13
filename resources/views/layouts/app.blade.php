<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EKSIS SMAN 2 Bangkalan')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/shared/app.css', 'resources/js/shared/app.js'])

    @stack('styles')
</head>
<body class="font-sans bg-[#f3f4f6] text-[#1f2937] antialiased min-h-screen flex flex-col justify-between relative">

    @yield('layout-content')

    <!-- Global Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none max-w-sm w-full px-4 sm:px-0"></div>

    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `flex items-center gap-3 p-4 rounded-2xl shadow-lg border text-sm font-medium transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto cursor-pointer`;

            if (type === 'success') {
                toast.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-800');
                toast.innerHTML = `
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="flex-grow">${message}</span>
                `;
            } else if (type === 'error') {
                toast.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-800');
                toast.innerHTML = `
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="flex-grow">${message}</span>
                `;
            } else {
                toast.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-800');
                toast.innerHTML = `
                    <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="flex-grow">${message}</span>
                `;
            }

            container.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Auto dismiss
            const dismiss = () => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[-10px]', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            };

            toast.onclick = dismiss;
            setTimeout(dismiss, 4000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
            @if($errors->any())
                showToast(@json($errors->first()), 'error');
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>
