<?php

namespace App\Filament\Resources\Sales\URSResource\Pages;

use App\Filament\Resources\Sales\URSResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateURS extends CreateRecord
{
    protected static string $resource = URSResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('URS created successfully')
            ->success()
            ->body('The URS has been added and is ready to be edited if needed.')
            ->actions([
                Action::make('view')->label('View Data')->button()
                    ->url(EditURS::getUrl(['record' => $this->record])),
            ]);
    }
}
