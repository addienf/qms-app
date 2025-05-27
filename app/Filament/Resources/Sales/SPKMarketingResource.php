<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\SPKMarketingResource\Pages;
use App\Filament\Resources\Sales\SPKMarketingResource\RelationManagers;
use App\Models\Sales\Pivot\SPKMarketingPIC;
use App\Models\Sales\SpesifikasiProduct;
use App\Models\Sales\SPKMarketing;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Forms\Components\Section;

class SPKMarketingResource extends Resource
{
    protected static ?string $model = SPKMarketing::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?string $navigationLabel = 'SPK Marketing';
    protected static ?string $pluralLabel = 'SPK Marketing';
    protected static ?string $modelLabel = 'SPK Marketing';
    public static function getSlug(): string
    {
        return 'spk-marketing';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Surat Perintah Kerja')
                    ->extraAttributes(['class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50 '])
                    ->schema([
                        Select::make('spesifikasi_product_id')
                            ->label('Spesifikasi Product')
                            ->required()
                            ->options(function () {
                                return SpesifikasiProduct::with('urs')
                                    ->get()
                                    ->mapWithKeys(function ($item) {
                                        return [$item->id => $item->urs->no_urs ?? '-'];
                                    });
                            }),

                        TextInput::make('no_order')
                            ->label('No Order')
                            ->required(),

                        DatePicker::make('tanggal')
                            ->label('Tanggal Dibuat')
                            ->required(),

                        TextInput::make('dari')
                            ->label('Dari')
                            ->required(),

                        TextInput::make('kepada')
                            ->label('Kepada')
                            ->required(),

                        Grid::make(2)
                            ->relationship('spkMarketingPIC')
                            ->schema([
                                TextInput::make('create_name')
                                    ->label('Yang Membuat')
                                    ->required(),

                                TextInput::make('recieve_name')
                                    ->label('Yang Menerima')
                                    ->required(),

                                static::getSignatureCreate(),

                                static::getSignatureRecieve(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('spesifikasiProduct.urs.no_urs')
                    ->label('No URS')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('no_order')
                    ->label('No Order')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('spkMarketingPIC.create_signature')
                    ->label('Tanda Tangan Pembuat')
                    ->width(100)
                    ->height(50),
                ImageColumn::make('spkMarketingPIC.recieve_signature')
                    ->label('Tanda Tangan Penerima')
                    ->width(100)
                    ->height(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('pdf_view')
                    ->label(_('View PDF'))
                    ->icon('heroicon-o-document')
                    ->color('success')
                    ->url(fn($record) => self::getUrl('pdfView', ['record' => $record->id])),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSPKMarketings::route('/'),
            'create' => Pages\CreateSPKMarketing::route('/create'),
            'edit' => Pages\EditSPKMarketing::route('/{record}/edit'),
            'pdfView' => Pages\SPKMarketingPDF::route('/{record}/pdfView')
        ];
    }

    public static function getSignatureCreate(): SignaturePad
    {
        return
            SignaturePad::make('create_signature')
                ->label(__('Tanda Tangan'))

                ->nullable()
                ->afterStateUpdated(function ($state, $set) {
                    if (!$state || blank($state)) {
                        return;
                    }
                    $fileName = 'ttd_create_' . Str::random(10) . '.jpg';
                    $path = 'Sales/SPK/Signature/';
                    $imagePath = SPKMarketingPIC::convertBase64ToJpg2($state, $fileName, $path);
                    if ($imagePath) {
                        $set('create_signature', $imagePath);
                    }
                })
                ->afterStateHydrated(fn($state, $set) => $set('create_signature', $state));
        // ->afterStateUpdated(function ($state, $set) {
        //     if (!$state && blank($state))
        //         return;
        //     $fileName = 'ttd_create_' . Str::random(10) . '.jpg';
        //     $path = 'Sales/SPK/Signature/';
        //     $imagePath = SPKMarketingPIC::convertBase64ToJpg2($state, $fileName, $path);
        //     $set('create_signature', $imagePath);
        // });
    }

    public static function getSignatureRecieve(): SignaturePad
    {
        return
            SignaturePad::make('recieve_signature')
                ->label(__('Tanda Tangan'))
                ->nullable()
                ->afterStateUpdated(function ($state, $set) {
                    if (!$state || blank($state)) {
                        return;
                    }
                    $fileName = 'ttd_recieve_' . Str::random(10) . '.jpg';
                    $path = 'Sales/SPK/Signature/';
                    $imagePath = SPKMarketingPIC::convertBase64ToJpg2($state, $fileName, $path);
                    if ($imagePath) {
                        $set('recieve_signature', $imagePath);
                    }
                })
                ->afterStateHydrated(fn($state, $set) => $set('recieve_signature', $state));
        // ->afterStateUpdated(function ($state, $set) {
        //     if (!$state && blank($state))
        //         return;
        //     $fileName = 'ttd_recieve_' . Str::random(10) . '.jpg';
        //     $path = 'Sales/SPK/Signature/';
        //     $imagePath = SPKMarketingPIC::convertBase64ToJpg2($state, $fileName, $path);
        //     $set('recieve_signature', $imagePath);
        // });
    }
}