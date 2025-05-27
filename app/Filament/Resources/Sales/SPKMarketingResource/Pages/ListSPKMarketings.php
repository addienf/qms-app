<?php

namespace App\Filament\Resources\Sales\SPKMarketingResource\Pages;

use App\Filament\Resources\Sales\SPKMarketingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSPKMarketings extends ListRecords
{
    protected static string $resource = SPKMarketingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
