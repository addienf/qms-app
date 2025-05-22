<?php

namespace App\Filament\Resources\Sales\URSResource\Pages;

use App\Filament\Resources\Sales\URSResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListURS extends ListRecords
{
    protected static string $resource = URSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
