<?php

namespace App\Filament\Resources\Profile\CustomerResource\Pages;

use App\Filament\Resources\Profile\CustomerResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Notif Create
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Customer created successfully')
            ->success()
            ->body('The customer has been added and is ready to be edited if needed.')
            ->actions([
                Action::make('view')->label('View Data')->button()
                    ->url(EditCustomer::getUrl(['record' => $this->record])),
            ]);
    }
}
