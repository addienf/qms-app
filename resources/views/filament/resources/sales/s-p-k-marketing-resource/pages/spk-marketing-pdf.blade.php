<x-filament-panels::page>
    <x-filament::section>
    <h2 class="mb-3 text-xl font-bold text-center">Detail Surat Perintah Kerja</h2>

    <!-- HEADER DOKUMEN MIRIP EXCEL -->
    <table class="w-full max-w-4xl mx-auto text-sm border border-black dark:border-gray-600"
        style="border-collapse: collapse;">
        <tr>
            <!-- Logo -->
            <td rowspan="3" class="w-28 h-28 p-2 border border-black dark:border-gray-600 text-center align-middle">
                <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="object-contain h-30 mx-auto" />
            </td>
    
            <!-- Nama PT -->
            <td colspan="2" class="text-center font-bold border border-black dark:border-gray-600">
                PT. QLab Kinarya Sentosa
            </td>
        </tr>
        <tr>
            <!-- Judul Dokumen -->
            <td class="text-center font-bold border border-black dark:border-gray-600" style="font-size: 20px;">
                Surat Perintah Kerja
            </td>
            <!-- Info Dokumen -->
            <td rowspan="2" class="w-100 border dark:border-gray-600 p-0">
                <table class="w-full text-sm" style="border-collapse: collapse;">
                    <tr>
                        <td class="border border-black dark:border-gray-600 px-3 py-2">No. Dokumen</td>
                        <td class="border border-black dark:border-gray-600 px-3 py-2 font-semibold">
                            FO-QKS-MKT-01-03</td>
                    </tr>
                    <tr>
                        <td class="border border-black dark:border-gray-600 px-3 py-2">Tanggal Rilis</td>
                        <td class="border border-black dark:border-gray-600 px-3 py-2 font-semibold">12 Maret 2025
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-black dark:border-gray-600 px-3 py-2">Revisi</td>
                        <td class="border border-black dark:border-gray-600 px-3 py-2 font-semibold">0</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- Form Input -->
    <div class="grid max-w-4xl grid-cols-1 pt-6 mx-auto mb-6 text-sm md:grid-cols-2 gap-x-6 gap-y-4">
        @php
$fields = [
    ['label' => 'Tanggal :', 'value' => \Carbon\Carbon::parse($spk_mkt->tanggal)->translatedFormat('d F Y')],
    ['label' => 'No SPK :', 'value' => $spk_mkt->no_spk],
    ['label' => 'Customer :', 'value' => $spk_mkt->spesifikasiProduct->urs->customer->name],
    ['label' => 'Dari :', 'value' => $spk_mkt->dari],
    ['label' => 'No Order :', 'value' => $spk_mkt->no_order],
    ['label' => 'Kepada :', 'value' => $spk_mkt->kepada],
];
        @endphp

        @foreach ($fields as $field)
            <div class="flex flex-col items-start gap-2 md:flex-row md:gap-4 md:items-center">
                <label class="font-medium md:w-40">{{ $field['label'] }}</label>
                <input type="text"
                    class="flex-1 w-full px-2 py-1 text-black bg-white border border-gray-300 rounded cursor-not-allowed dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                    value="{{ $field['value'] }}" />
            </div>
        @endforeach
    </div>

    <!-- Tabel Produk -->
    <div class="max-w-4xl mx-auto overflow-x-auto">
        <table class="w-full text-sm text-left border border-gray-300 dark:border-gray-600">
            <thead class="text-black bg-gray-100 dark:bg-gray-800 dark:text-white">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Nomor</th>
                    <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Nama Produk</th>
                    <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Jumlah Pesanan</th>
                    <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">No URS</th>
                    <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Rencana Pengiriman</th>
                </tr>
            </thead>
            <tbody class="text-black bg-white dark:bg-gray-900 dark:text-white">
                @foreach ($spk_mkt->spesifikasiProduct->detailSpecifications as $item)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $item->product->product_name }}</td>
                        <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $spk_mkt->spesifikasiProduct->urs->no_urs }}</td>
                        <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ \Carbon\Carbon::parse($spk_mkt->spesifikasiProduct->date)->translatedFormat('d F Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Catatan & Tanda Tangan -->
    <div class="max-w-4xl mx-auto mt-10 text-sm">
        <p class="mb-4 dark:text-white">*Salinan URS Wajib diberikan kepada Departemen Produksi</p>
        <div class="flex items-start justify-between gap-4">
            <!-- Kiri -->
            <div class="flex flex-col items-center">
                <p class="mb-2 dark:text-white">Yang Membuat</p>
                <img src="{{ asset('storage/' . $spk_mkt->spkMarketingPIC->create_signature) }}" alt="Product Signature"
                        class="h-20 w-80" />
                <p class="mt-1 font-semibold dark:text-white">{{$spk_mkt->dari}}</p>
                <p class="mt-1 font-semibold dark:text-white">Marketing</p>
            </div>
            <!-- Kanan -->
            <div class="flex flex-col items-center">
                <p class="mb-2 dark:text-white">Yang Menerima</p>
                <img src="{{ asset('storage/' . $spk_mkt->spkMarketingPIC->recieve_signature) }}" alt="Product Signature"
                        class="h-20 w-80" />
                <p class="mt-1 font-semibold dark:text-white">{{$spk_mkt->kepada}}</p>
                <p class="mt-1 font-semibold dark:text-white">Produksi</p>
            </div>
        </div>
    </div>

</x-filament::section>
</x-filament-panels::page>
