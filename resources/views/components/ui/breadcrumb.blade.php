@props([
    'items' => [] // Array link. Format: [['label' => 'Dashboard', 'url' => '#'], ['label' => 'List Admin']]
])

<nav class="flex mb-5 text-xs font-semibold text-gray-500 tracking-wide" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-brand-primary transition-colors gap-1">
                <!-- Home Icon -->
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span>Beranda</span>
            </a>
        </li>
        
        @foreach($items as $item)
            <li>
                <div class="flex items-center gap-1.5 md:gap-2">
                    <!-- Chevron Right Icon -->
                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" class="text-gray-500 hover:text-brand-primary transition-colors">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="text-brand-primary font-bold" aria-current="page">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
