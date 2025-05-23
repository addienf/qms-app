<?php

namespace App\Filament\Resources\Profile;

use App\Filament\Resources\Profile\CustomerResource\Pages;
use App\Filament\Resources\Profile\CustomerResource\RelationManagers;
use App\Models\Profile\Customer;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Forms\Components\Section;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Profile';
    protected static ?string $navigationLabel = 'Customer';
    protected static ?string $pluralLabel = 'Customer';
    protected static ?string $modelLabel = 'Customer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->description('Lengkapi data Customer.')
                    ->extraAttributes(['class' => 'border-2 border-blue-300 rounded-md p-4 dark:border-blue-50'])
                    ->schema([
                        TextInput::make('name')
                            ->label('Customer Name')
                            ->required(),

                        TextInput::make('department')
                            ->label('Department')
                            ->required(),

                        PhoneInput::make('phone_number')
                            ->label('Phone Number')
                            ->required(),

                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->required(),

                        TextInput::make('company_address')
                            ->label('Company Address')
                            ->required(),
                    ])
                    ->columns(2), // 2 kolom agar tampilan lebih efisien
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('department')->searchable()->sortable(),
                TextColumn::make('phone_number')->searchable()->sortable(),
                TextColumn::make('company_name')->searchable()->sortable(),
                TextColumn::make('company_address')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->color('success'),
                    EditAction::make()->slideOver()->color('warning'),
                    DeleteAction::make()
                        ->successNotification(null)
                        ->after(function ($record) {
                            Notification::make()
                                ->title('Customer deleted successfully')
                                ->body("The customer \"{$record->name}\" has been permanently removed.")
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}