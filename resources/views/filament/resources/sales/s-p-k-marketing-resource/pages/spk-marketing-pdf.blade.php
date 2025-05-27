<x-filament-panels::page>
    <x-filament::section>
    {{ $spk_mkt }}
    <h2 class="mb-3 text-xl font-bold text-center">Detail Surat Perintah Kerja</h2>
    
    <!-- Header Dokumen -->
    <div
        class="flex flex-col w-full max-w-4xl text-sm text-center border border-black dark:border-gray-600 sm:flex-row mx-auto">
        <div class="flex items-center justify-center w-24 h-24 p-2 border border-black dark:border-gray-600">
            <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="object-contain w-16 h-16" />
        </div>
        <div
            class="flex items-center justify-center flex-1 px-2 py-2 font-semibold border border-black dark:border-gray-600">
            Permintaan Spesifikasi Produk
        </div>
        <div class="flex items-center justify-center flex-1 px-2 py-2 border border-black dark:border-gray-600">
            No Dokumen:<br><span class="font-semibold">XXXX</span>
        </div>
        <div class="flex items-center justify-center flex-1 px-2 py-2 border border-black dark:border-gray-600">
            Tanggal Rilis:<br><span class="font-semibold">8 Mei 2025</span>
        </div>
        <div class="flex items-center justify-center flex-1 px-2 py-2 border border-black dark:border-gray-600">
            Revisi:<br><span class="font-semibold">0</span>
        </div>
    </div>
    
    <!-- Form Input -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm mb-6 pt-6 max-w-4xl mx-auto">
        @php
            $fields = [
                ['label' => 'No :', 'value' => ''],
                ['label' => 'Nama :', 'value' => ''],
                ['label' => 'Department :', 'value' => ''],
                ['label' => 'Phone Number :', 'value' => ''],
                ['label' => 'Company Name :', 'value' => ''],
                ['label' => 'Company Address :', 'value' => ''],
            ];
        @endphp
    
        @foreach ($fields as $field)
            <div class="flex flex-col md:flex-row gap-2 md:gap-4 items-start md:items-center">
                <label class="md:w-40 font-medium">{{ $field['label'] }}</label>
                <input type="text"
                    class="w-full px-2 py-1 flex-1 border border-gray-300 dark:border-gray-600 rounded bg-white text-black dark:bg-gray-800 dark:text-white"
                    value="{{ $field['value'] }}" />
            </div>
        @endforeach
    </div>
    
    <!-- Tabel Produk -->
    <div class="overflow-x-auto max-w-4xl mx-auto">
        <table class="w-full border border-gray-300 dark:border-gray-600 text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-800 text-black dark:text-white">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Nomor</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Jumlah Pesanan</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">No URS</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Rencana Pengiriman</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 text-black dark:text-white">
                <tr>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">1</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">Produk A</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">10</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">URS-001</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">10 Juni 2025</td>
                </tr>
                <!-- Tambahkan baris lainnya jika perlu -->
            </tbody>
        </table>
    </div>
    
    <!-- Catatan & Tanda Tangan -->
    <div class="mt-10 text-sm max-w-4xl mx-auto">
        <p class="mb-4 dark:text-white">*Salinan URS Wajib diberikan kepada Departemen Produksi</p>
        <div class="flex justify-between items-start gap-4">
            <!-- Kiri -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 border border-black dark:border-gray-600 mb-2"></div>
                <p class="dark:text-white">Yang Membuat</p>
                <p class="mt-1 font-semibold dark:text-white">Marketing</p>
            </div>
            <!-- Kanan -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 border border-black dark:border-gray-600 mb-2"></div>
                <p class="dark:text-white">Yang Menerima</p>
                <p class="mt-1 font-semibold dark:text-white">Produksi</p>
            </div>
        </div>
    </div>

</x-filament::section>
</x-filament-panels::page>
