<?php

namespace App\Filament\Resources\Sales\SpesifikasiProductResource\Pages;

use App\Filament\Resources\Sales\SpesifikasiProductResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSpesifikasiProduct extends EditRecord
{
    protected static string $resource = SpesifikasiProductResource::class;

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('URS updated successfully')
            ->warning()
            ->body('The URS information has been updated.')
            ->actions([
                Action::make('edit')
                    ->label('View Again')
                    ->url(EditSpesifikasiProduct::getUrl(['record' => $this->record]))
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
