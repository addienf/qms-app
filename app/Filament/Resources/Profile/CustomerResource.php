<?php

namespace App\Filament\Resources\Profile;

use App\Filament\Resources\Profile\CustomerResource\Pages;
use App\Filament\Resources\Profile\CustomerResource\RelationManagers;
use App\Models\Profile\Customer;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

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
                //
                TextInput::make('name')->label('Customer Name')->required(),
                TextInput::make('department')->required(),
                PhoneInput::make('phone_number')->required(),
                TextInput::make('company_name')->required(),
                TextInput::make('company_address')->required()
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
                    Tables\Actions\ViewAction::make()->color('success'),
                    Tables\Actions\EditAction::make()->slideOver()->color('warning'),
                    Tables\Actions\DeleteAction::make(),
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
