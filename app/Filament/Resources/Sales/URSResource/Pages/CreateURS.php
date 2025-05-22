<?php

namespace App\Filament\Resources\Sales\URSResource\Pages;

use App\Filament\Resources\Sales\URSResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateURS extends CreateRecord
{
    protected static string $resource = URSResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
