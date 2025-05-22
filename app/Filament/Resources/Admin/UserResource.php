<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\UserResource\Pages;
use App\Filament\Resources\Admin\UserResource\RelationManagers;
use App\Models\Admin\User;
use App\Models\User as ModelsUser;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = ModelsUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'User';
    protected static ?string $pluralLabel = 'User';
    protected static ?string $modelLabel = 'User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')->required(),
                TextInput::make('email')->required(),
                TextInput::make('password')->password()->required()->revealable()->visibleOn('create')
                    ->rule('regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/')
                    ->helperText('Minimal 8 karakter, ada huruf besar, huruf kecil, dan angka')
                    ->validationMessages([
                        'required' => 'The password field is required.',
                        'regex' => 'The password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, and one number.',
                    ]),
                Select::make('role')->label('Role User')->label('Role User')
                    ->options(config('roles.user_roles'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('role')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('success'),
                    Tables\Actions\EditAction::make()->slideOver()->color('warning'),
                    Tables\Actions\DeleteAction::make()
                        ->successNotification(null)
                        ->after(function ($record) {
                            Notification::make()
                                ->title('User deleted successfully')
                                ->body("The User \"{$record->name}\" has been permanently removed.")
                                ->danger()
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
