<x-filament-panels::page>
    <x-filament::section>

        <p>Hello This Is Spesifikasi PDF</p>
        {{ $spesifikasi }}

        <h2 class="mb-3 text-xl font-bold text-center">Detail Permintaan Spesifikasi Produk</h2>

        <!-- Header Dokumen -->
        <div class="flex flex-col max-w-full text-sm text-center border border-black sm:flex-row">
            <div class="flex items-center justify-center w-24 h-24 p-2 border border-black">
                <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="object-contain w-16 h-16" />
            </div>
            <div class="flex items-center justify-center flex-1 px-4 py-3 font-semibold border border-black">
                Permintaan Spesifikasi Produk
            </div>
            <div class="flex items-center justify-center flex-1 px-4 py-3 border border-black">
                No Dokumen:<br><span class="font-semibold">XXXX</span>
            </div>
            <div class="flex items-center justify-center flex-1 px-4 py-3 border border-black">
                Tanggal Rilis:<br><span class="font-semibold">8 Mei 2025</span>
            </div>
            <div class="flex items-center justify-center flex-1 px-4 py-3 border border-black">
                Revisi:<br><span class="font-semibold">0</span>
            </div>
        </div>

        <!-- Form Informasi Umum -->
        <div class="grid max-w-4xl grid-cols-2 pt-6 mx-auto text-sm gap-x-8 gap-y-4">
            <div class="flex items-center gap-4">
                <label class="w-40 font-medium">No :</label>
                <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->urs->no_urs }}"/>
            </div>
            <div class="flex items-center gap-4">
                <label class="w-40 font-medium">Phone Number :</label>
                <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->urs->customer->phone_number }}"/>
            </div>
            <div class="flex items-center gap-4">
                <label class="w-40 font-medium">Nama :</label>
                <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->urs->customer->name }}"/>
            </div>
            <div class="flex items-center gap-4">
                <label class="w-40 font-medium">Company Name :</label>
                <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->urs->customer->company_name }}"/>
            </div>
            <div class="flex items-center gap-4">
                <label class="w-40 font-medium">Department :</label>
                <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->urs->customer->department }}"/>
            </div>
            <div class="flex items-center gap-4">
                <label class="w-40 font-medium">Company Address :</label>
                <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->urs->customer->company_address }}"/>
            </div>
        </div>

        <!-- Form Spesifikasi Teknis -->
        <div class="grid max-w-4xl grid-cols-2 pt-6 mx-auto text-sm gap-x-8 gap-y-4">
            {{-- <div>
                <label class="block mb-2 font-medium">Nama Item</label>
                <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->detailSpecifications[0]->product->product_name }}"/>
            </div>
            <div>
                <label class="block mb-2 font-medium">Quantity</label>
                <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded" value="{{ $spesifikasi->detailSpecifications[0]->quantity }}"/>
            </div> --}}
            @foreach ($spesifikasi->detailSpecifications as $detail)
                <div class="p-4 mb-4 border border-gray-300 rounded">
                    <div>
                        <label class="block mb-2 font-medium">Nama Item</label>
                        <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded" value="{{ $detail->product->product_name }}"/>
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Quantity</label>
                        <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded" value="{{ $detail->quantity }}"/>
                    </div>

                    @foreach ($detail->specification as $spec)
                        <div>
                            <label class="block mb-2 font-medium">{{ $spec['name'] }}</label>
                            <input type="text" class="w-full px-2 py-1 border border-gray-300 rounded" value="{{ ($spec['name'] === 'Water Feeding System' || $spec['name'] === 'Software') ? ($spec['value'] == '1' ? 'Ya' : 'Tidak') : $spec['value'] }}"/>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- Penanggung Jawab -->
        <div class="max-w-4xl pt-10 mx-auto text-sm">
            <div>
                <label class="block mb-2 font-medium">Penanggung Jawab</label>
                <div
                    class="flex items-center justify-center h-20 text-xs text-gray-500 bg-white border border-gray-400 rounded w-28">
                    {{ $spesifikasi->productPic->pic_name }}
                    <img src="{{ asset('storage/' . $spesifikasi->productPic->pic_signature) }}"
                        alt="Product Image"
                        class="border rounded w-100" />
                </div>
            </div>
            <div>
                <label class="block mb-2 font-medium">Tanggal</label>
                <input type="text" class="w-48 px-2 py-1 border border-gray-300 rounded" value="{{ \Carbon\Carbon::parse($spesifikasi->date)->translatedFormat('d F Y') }}" />
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
