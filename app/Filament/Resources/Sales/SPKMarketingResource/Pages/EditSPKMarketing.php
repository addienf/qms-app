<?php

namespace App\Filament\Resources\Sales\SPKMarketingResource\Pages;

use App\Filament\Resources\Sales\SPKMarketingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSPKMarketing extends EditRecord
{
    protected static string $resource = SPKMarketingResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
