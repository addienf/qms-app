<?php

namespace App\Filament\Resources\Profile\CustomerResource\Pages;

use App\Filament\Resources\Profile\CustomerResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Notif Edit
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Customer updated successfully')
            ->warning()
            ->body('The customer information has been updated.')
            ->actions([
                Action::make('edit')
                    ->label('View Again')
                    ->url(EditCustomer::getUrl(['record' => $this->record]))
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
