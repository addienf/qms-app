<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\ProductResource\Pages;
use App\Filament\Resources\Inventory\ProductResource\RelationManagers;
use App\Models\Inventory\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Inventory';
    protected static ?string $navigationLabel = 'Product';
    protected static ?string $pluralLabel = 'Product';
    protected static ?string $modelLabel = 'Product';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('product_name')->required()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->readOnly(),
                Select::make('category_id')->label('Category Product')->required()
                    ->relationship('category', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('product_name')->searchable()->sortable(),
                TextColumn::make('category.name')->searchable()->sortable()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
