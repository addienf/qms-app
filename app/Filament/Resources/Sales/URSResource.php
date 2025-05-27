<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\URSResource\Pages;
use App\Filament\Resources\Sales\URSResource\RelationManagers;
use App\Models\Sales\URS;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;

class URSResource extends Resource
{
    protected static ?string $model = URS::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?string $navigationLabel = 'URS';
    protected static ?string $pluralLabel = 'URS';
    protected static ?string $modelLabel = 'URS';
    public static function getSlug(): string
    {
        return 'urs';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->extraAttributes(['class' => 'border-2 border-blue-300 rounded-md dark:border-blue-50'])
                    ->schema([
                        TextInput::make('no_urs')
                            ->label('No URS')
                            ->required()
                            ->helperText('Format: XXX/QKS/MKT/URS/MM/YY'),
                        Select::make('customer_id')
                            ->label('Customer')
                            ->required()
                            ->relationship('customer', 'name'),
                        RichEditor::make('remark_permintaan_khusus')
                            ->label('Permintaan Khusus')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('no_urs')->searchable()->sortable(),
                TextColumn::make('customer.name')->searchable()->sortable(),
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
                                ->title('URS deleted successfully')
                                ->body("The URS \"{$record->no_urs}\" has been permanently removed.")
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
            'index' => Pages\ListURS::route('/'),
            'create' => Pages\CreateURS::route('/create'),
            'edit' => Pages\EditURS::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('customer.name')->label('Customer Name'),
                TextEntry::make('no_urs')->label('No URS'),
            ]);
    }
}
