<?php

namespace App\Filament\Resources\Sales\SpesifikasiProductResource\Pages;

use App\Filament\Resources\Sales\SpesifikasiProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpesifikasiProducts extends ListRecords
{
    protected static string $resource = SpesifikasiProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
