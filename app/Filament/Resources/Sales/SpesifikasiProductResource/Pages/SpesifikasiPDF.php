<?php

namespace App\Filament\Resources\Sales\SpesifikasiProductResource\Pages;

use App\Filament\Resources\Sales\SpesifikasiProductResource;
use App\Models\Sales\SpesifikasiProduct;
use Filament\Resources\Pages\Page;

class SpesifikasiPDF extends Page
{
    protected static string $resource = SpesifikasiProductResource::class;

    protected static string $view = 'filament.resources.sales.spesifikasi-product-resource.pages.spesifikasi-pdf';

    public $record;
    public $spesifikasi;

    public function mount($record)
    {
        $this->record = $record;
        $this->spesifikasi = SpesifikasiProduct::with(['urs', 'productPic', 'detailSpecifications'])->find($record);
    }
}
