<?php

namespace App\Filament\Resources\Admin\UserResource\Pages;

use App\Filament\Resources\Admin\UserResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('User created successfully')
            ->success()
            ->body('The User has been added and is ready to be edited if needed.')
            ->actions([
                Action::make('view')->label('View Data')->button()
                    ->url(EditUser::getUrl(['record' => $this->record])),
            ]);
    }
}
