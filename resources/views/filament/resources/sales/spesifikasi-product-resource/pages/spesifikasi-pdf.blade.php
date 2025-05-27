<x-filament-panels::page>
    <x-filament::section>
        <h2 class="mb-3 text-xl font-bold text-center">Detail Permintaan Spesifikasi Produk</h2>

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

        <!-- Form Informasi Umum -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 max-w-4xl mx-auto text-sm pt-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                <label class="sm:w-40 font-medium">No :</label>
                <input type="text" disabled
                    class="flex-1 px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded w-full cursor-not-allowed"
                    value="{{ $spesifikasi->urs->no_urs }}" />
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                <label class="sm:w-40 font-medium">Phone Number :</label>
                <input type="text" disabled
                    class="flex-1 px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded w-full cursor-not-allowed"
                    value="{{ $spesifikasi->urs->customer->phone_number }}" />
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                <label class="sm:w-40 font-medium">Nama :</label>
                <input type="text" disabled
                    class="flex-1 px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded w-full cursor-not-allowed"
                    value="{{ $spesifikasi->urs->customer->name }}" />
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                <label class="sm:w-40 font-medium">Company Name :</label>
                <input type="text" disabled
                    class="flex-1 px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded w-full cursor-not-allowed"
                    value="{{ $spesifikasi->urs->customer->company_name }}" />
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                <label class="sm:w-40 font-medium">Department :</label>
                <input type="text" disabled
                    class="flex-1 px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded w-full cursor-not-allowed"
                    value="{{ $spesifikasi->urs->customer->department }}" />
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                <label class="sm:w-40 font-medium">Company Address :</label>
                <input type="text" disabled
                    class="flex-1 px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded w-full cursor-not-allowed"
                    value="{{ $spesifikasi->urs->customer->company_address }}" />
            </div>
        </div>

        <!-- Form Spesifikasi Teknis -->
        <div class="grid max-w-4xl grid-cols-2 pt-6 mx-auto text-sm gap-x-8 gap-y-4">
            @foreach ($spesifikasi->detailSpecifications as $detail)
                <div class="p-4 mb-4 border border-gray-300 dark:border-gray-600 rounded">
                    <div>
                        <label class="block mb-2 font-medium">Nama Item</label>
                        <input type="text" disabled
                            class="w-full px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded cursor-not-allowed"
                            value="{{ $detail->product->product_name }}" />
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Quantity</label>
                        <input type="text" disabled
                            class="w-full px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded cursor-not-allowed"
                            value="{{ $detail->quantity }}" />
                    </div>

                    @foreach ($detail->specification as $spec)
                        <div>
                            <label class="block mb-2 font-medium">{{ $spec['name'] }}</label>
                            <input type="text" disabled
                                class="w-full px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded cursor-not-allowed"
                                value="{{ ($spec['name'] === 'Water Feeding System' || $spec['name'] === 'Software') ? ($spec['value'] == '1' ? 'Ya' : 'Tidak') : $spec['value'] }}" />
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- Penanggung Jawab -->
        <div class="max-w-4xl pt-4 mx-auto text-sm">
            <div>
                <label class="font-bold pt-3">Penanggung Jawab</label>
                <div class="flex flex-col text-sm pt-3">
                    <img src="{{ asset('storage/' . $spesifikasi->productPic->pic_signature) }}" alt="Product Signature"
                        class="h-20 w-80" />
                    <div class="mt-2 font-medium">
                        {{ $spesifikasi->productPic->pic_name }}
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="font-bold">Tanggal: </label>
                <input type="text" readonly disabled
                    class="px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded cursor-not-allowed"
                    value="{{ \Carbon\Carbon::parse($spesifikasi->date)->translatedFormat('d F Y') }}" />
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>