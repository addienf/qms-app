<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\SpesifikasiProductResource\Pages;
use App\Filament\Resources\Sales\SpesifikasiProductResource\Pages\SpesifikasiPDF;
use App\Filament\Resources\Sales\SpesifikasiProductResource\RelationManagers;
use App\Models\Sales\Pivot\SpesifikasiProductPIC;
use App\Models\Sales\SpesifikasiProduct;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Components\Fieldset as ComponentsFieldset;
use Filament\Infolists\Components\Grid as ComponentsGrid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Illuminate\Support\Facades\Storage;
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
        return $form->schema([
            Section::make('URS')
                ->extraAttributes([
                    'class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50'
                ])
                ->schema([
                    Grid::make(4)->schema([
                        Select::make('urs_id')
                            ->label('No URS')
                            ->required()
                            ->relationship('urs', 'no_urs'),

                        DatePicker::make('date')
                            ->label('Tanggal Dibuat')
                            ->required(),

                        TextInput::make('delivery_address')
                            ->required(),

                        ToggleButtons::make('is_stock')
                            ->boolean()
                            ->required()
                            ->inline()
                            ->inlineLabel(false)
                            ->label('Stock')
                            ->extraAttributes(['class' => 'text-white']),
                    ]),
                ]),

            Section::make('Product Request')
                ->extraAttributes([
                    'class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50'
                ])
                ->schema([
                    Repeater::make('detailSpecifications')
                        ->label('')
                        ->relationship()
                        ->schema([
                            Fieldset::make('Pilih Product')
                                ->schema([
                                    Grid::make(2)->schema([
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

                                        Fieldset::make('detailInformation')
                                            ->label('Masukkan File Pendukung')
                                            ->relationship('detailInformation')
                                            ->schema([
                                                FileUpload::make('file_path')
                                                    ->label('')
                                                    ->directory('Sales/Spesifikasi/Files')
                                                    ->acceptedFileTypes(['application/pdf'])
                                                    ->maxSize(10240)
                                                    ->columnSpanFull()
                                                    ->helperText('Hanya file PDF yang diperbolehkan. Maksimal ukuran 10 MB.'),
                                            ]),
                                    ]),
                                ]),

                            TableRepeater::make('specification')
                                ->label('Pilih Spesifikasi')
                                ->schema([
                                    Select::make('name')
                                        ->reactive()
                                        ->required()
                                        ->label('Jenis Spesifikasi')
                                        ->options(config('spec_config.spesifikasi'))
                                        ->columnSpan(1),

                                    ToggleButtons::make('value')
                                        ->boolean()
                                        ->required()
                                        ->inline()
                                        ->inlineLabel(false)
                                        ->label('Nilai')
                                        ->visible(fn($get) => in_array($get('name'), ['Water Feeding System', 'Software']))
                                        ->columnSpan(1),

                                    TextInput::make('value')
                                        ->required()
                                        ->label('Nilai')
                                        ->visible(fn($get) => !in_array($get('name'), ['Water Feeding System', 'Software']))
                                        ->columnSpan(1),
                                ])
                                ->columns(2)
                                ->defaultItems(1)
                                ->columnSpanFull()
                                ->addActionLabel('Add Specification'),
                        ])
                        ->columns(1)
                        ->addActionLabel('Add Product'),
                ]),

            Fieldset::make('Detail Specification')
                ->schema([
                    Grid::make()->columns(['sm' => 2])->schema([
                        RichEditor::make('detail_specification')
                            ->required()
                            ->helperText('Berikan penjelasan tentang produk ini.')
                            ->columnSpan(1),

                        Group::make()
                            ->relationship('productPic')
                            ->schema([
                                Hidden::make('pic_name')
                                    ->default(Auth::user()->name)
                                    ->label('Nama PIC')
                                    ->required(),

                                static::getSignature2(),
                            ])->columnSpan(1),
                    ])->columns(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('urs.customer.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('urs.no_urs')
                    ->label('No URS')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('delivery_address')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Action::make('pdf_view')
                    ->label(_('View PDF'))
                    ->icon('heroicon-o-document')
                    ->color('success')
                    ->url(fn($record) => self::getUrl('pdfView', ['record' => $record->id])),

                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('success'),

                    Tables\Actions\EditAction::make()
                        ->slideOver()
                        ->color('warning'),

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
        return $infolist->schema([
            ComponentsFieldset::make('Detail Information')->schema([
                TextEntry::make('urs.no_urs')->label('No URS'),
                TextEntry::make('urs.customer.name')->label('Name'),
                TextEntry::make('urs.customer.department')->label('Department'),
                TextEntry::make('urs.customer.phone_number')->label('Phone Number'),
                TextEntry::make('urs.customer.company_name')->label('Company Name'),
                TextEntry::make('urs.customer.company_address')->label('Company Address'),
            ]),

            ComponentsFieldset::make('Product Request')->schema([
                RepeatableEntry::make('detailSpecifications')->schema([
                    ComponentsGrid::make(2)->schema([
                        TextEntry::make('product.product_name')->label('Product Name'),
                        TextEntry::make('product.category.name')->label('Product Category'),

                        ComponentsFieldset::make('detailInformation')
                            ->label('File Pendukung')
                            ->schema([
                                TextEntry::make('detailInformation.file_path')
                                    ->label('Lampiran')
                                    ->url(fn($record) => Storage::url($record->detailInformation?->file_path))
                                    ->openUrlInNewTab(),
                            ]),
                    ]),

                    RepeatableEntry::make('specification')->label('Specification')->schema([
                        ComponentsGrid::make(2)->schema([
                            TextEntry::make('name')->label('Jenis Spesifikasi'),
                            TextEntry::make('value')
                                ->label('Nilai')
                                ->badge()
                                ->color(fn($state) => $state === '1' ? 'success' : ($state === '0' ? 'danger' : null))
                                ->formatStateUsing(fn($state) => $state === '1' ? 'Yes' : ($state === '0' ? 'No' : $state)),
                        ]),
                    ]),
                ])->columnSpanFull(),
            ]),

            ComponentsFieldset::make('PIC')->schema([
                ImageEntry::make('productPic.pic_signature')
                    ->label('Tanda Tangan')
                    ->inlineLabel()
                    ->width(100)
                    ->height(50),

                TextEntry::make('productPic.pic_name')
                    ->inlineLabel()
                    ->label('Dibuat Oleh'),

                TextEntry::make('date')
                    ->inlineLabel()
                    ->label('Tanggal Dibuat')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d F Y')),
            ])->columns(1),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpesifikasiProducts::route('/'),
            'create' => Pages\CreateSpesifikasiProduct::route('/create'),
            'edit' => Pages\EditSpesifikasiProduct::route('/{record}/edit'),
            'pdfView' => Pages\SpesifikasiPDF::route('/{record}/pdfView'),
        ];
    }

    public static function getSignature2(): SignaturePad
    {
        return SignaturePad::make('pic_signature')
            ->label(__('Tanda Tangan'))
            ->nullable()
            ->exportPenColor('#0118D8')
            ->confirmable()
            ->afterStateUpdated(function ($state, $set) {
                if (blank($state))
                    return;

                $fileName = 'ttd_' . Str::random(10) . '.jpg';
                $path = 'Sales/Spesifikasi/Signature/';
                $imagePath = SpesifikasiProductPIC::convertBase64ToJpg2($state, $fileName, $path);

                if ($imagePath) {
                    $set('pic_signature', $imagePath);
                }
            });
    }
}