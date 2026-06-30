@props([
    'headers' => [] // Array string untuk kolom header tabel
])

<div class="table-container shadow-sm border border-[#f2eaea]">
    <table class="min-w-full divide-y divide-[#f2eaea]">
        <thead class="bg-[#FCFBFB]">
            <tr>
                @foreach($headers as $header)
                    <th scope="col" class="table-header-cell text-xs tracking-wider uppercase font-semibold text-gray-500">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-[#f2eaea] bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
