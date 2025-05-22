<?php

namespace App\Filament\Resources\Sales\URSResource\Pages;

use App\Filament\Resources\Sales\URSResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditURS extends EditRecord
{
    protected static string $resource = URSResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('URS updated successfully')
            ->warning()
            ->body('The URS information has been updated.')
            ->actions([
                Action::make('edit')
                    ->label('View Again')
                    ->url(EditURS::getUrl(['record' => $this->record]))
                    ->button(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
