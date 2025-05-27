<?php

namespace App\Filament\Resources\Sales\SPKMarketingResource\Pages;

use App\Filament\Resources\Sales\SPKMarketingResource;
use App\Models\Sales\SPKMarketing;
use Filament\Resources\Pages\Page;

class SPKMarketingPDF extends Page
{
    protected static string $resource = SPKMarketingResource::class;

    protected static string $view = 'filament.resources.sales.s-p-k-marketing-resource.pages.spk-marketing-pdf';
    protected static ?string $title = 'Spesifikasi Produk PDF';
    public $record;
    public $spk_mkt;

    public function mount($record)
    {
        $this->record = $record;
        $this->spk_mkt = SPKMarketing::with(['spesifikasiProduct', 'spkMarketingPIC'])->find($record);
    }
}
