<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\SpesifikasiProductResource\Pages;
use App\Filament\Resources\Sales\SpesifikasiProductResource\RelationManagers;
use App\Models\Sales\SpesifikasiProduct;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class SpesifikasiProductResource extends Resource
{
    protected static ?string $model = SpesifikasiProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?string $navigationLabel = 'Spesifikasi Product';
    protected static ?string $pluralLabel = 'Spesifikasi Product';
    protected static ?string $modelLabel = 'Spesifikasi Product';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Grid::make(4)
                    ->schema([
                        Select::make('urs_id')->label('No URS')->required()
                            ->relationship('urs', 'no_urs'),
                        DatePicker::make('date')->label('Tanggal Dibuat')->required(),
                        TextInput::make('delivery_address')->required(),
                        ToggleButtons::make('is_stock')->boolean()->required()->inline()->inlineLabel(false)
                            ->label('Stock')
                    ]),
                Section::make('')
                    ->description('Silakan isi data permintaan URS di bawah ini.')
                    ->extraAttributes(['class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50'])
                    ->schema([
                        Repeater::make('specificationProducts')
                            ->label('Pilih Produk')
                            ->relationship()
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('Product')
                                            ->required()
                                            ->relationship('product', 'product_name')
                                            ->columnSpan(1),

                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->default(1)
                                            ->required()
                                            ->columnSpan(1),
                                    ]),
                                Repeater::make('specification')
                                    ->label('Pilih Spesifikasi')
                                    ->schema([
                                        Select::make('name')->reactive()->required()
                                            ->label('Jenis Spesifiaksi')
                                            ->options(config('spec_config.spesifikasi'))
                                            ->columnSpan(1),
                                        ToggleButtons::make('value')->boolean()->required()->inline()->inlineLabel(false)
                                            ->label('Nilai')
                                            ->visible(fn($get) => in_array($get('name'), ['water_feeding_system', 'software']))
                                            ->columnSpan(1),
                                        TextInput::make('value')->required()
                                            ->label('Nilai')
                                            ->visible(fn($get) => !in_array($get('name'), ['water_feeding_system', 'software']))
                                            ->columnSpan(1),
                                        Repeater::make('detailInformation')->label('File Pendukung')->relationship()
                                            ->schema([
                                                TextInput::make('file_path')->label('File Path')->required(),
                                            ])->columns(1)->defaultItems(1)->minItems(1)->maxItems(1)
                                    ])->columns(2)->defaultItems(1)->columnSpanFull()->addActionLabel('Add Specification'),
                            ])->columns(1)->addActionLabel('Add Product'),
                    ]),
                RichEditor::make('detail_specification')->required()->columnSpanFull()
                    ->extraAttributes(['class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50']),
                Repeater::make('productPics')
                    ->extraAttributes(['class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50'])
                    ->label('PIC')
                    ->relationship() // relasi ke SpesifikasiProductPic
                    ->schema([
                        Forms\Components\TextInput::make('pic_name')
                            ->label('Nama PIC')
                            ->required(),
                        Forms\Components\TextInput::make('pic_signature')
                            ->label('Tanda Tangan (path atau base64)')
                            ->required(),
                    ])->columns(2)->defaultItems(1)->minItems(1)->maxItems(1)->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('urs.customer.name')->searchable()->sortable(),
                TextColumn::make('urs.no_urs')->label('No URS')->searchable()->sortable(),
                TextColumn::make('date')->searchable()->sortable(),
                TextColumn::make('delivery_address')->searchable()->sortable(),
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
                                ->title('Spesifikasi Product deleted successfully')
                                ->body("The Spesifikasi Product \"{$record->no_urs}\" has been permanently removed.")
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('urs.customer.name')->label('Customer Name')->extraAttributes([
                    'class' => 'border-2 border-red-500 rounded-md',
                ]),
                TextEntry::make('urs.no_urs')->label('No URS'),
                TextEntry::make('date'),
                TextEntry::make('delivery_address'),
                RepeatableEntry::make('specificationProducts')->label('Products')
                    ->schema([
                        TextEntry::make('product.product_name'),
                        TextEntry::make('quantity'),
                    ])->columns(2)->columnSpanFull(),
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
            'index' => Pages\ListSpesifikasiProducts::route('/'),
            'create' => Pages\CreateSpesifikasiProduct::route('/create'),
            'edit' => Pages\EditSpesifikasiProduct::route('/{record}/edit'),
        ];
    }
}