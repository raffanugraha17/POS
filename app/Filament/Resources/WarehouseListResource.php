<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseListResource\Pages;
use App\Filament\Resources\WarehouseListResource\RelationManagers;
use App\Models\WarehouseList;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarehouseListResource extends Resource
{
    protected static ?string $model = WarehouseList::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Purchasing";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('warehouse')->label('Warehouse')->required(),
                Select::make('type')->label('Type')
                    ->options([
                        'clean' => 'Clean',
                        'dirty' => 'Dirty',
                    ]),
                TextInput::make('location')->label('Location')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse')->label('Warehouse')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('location')->label('Location')->sortable()->searchable(),
            ])
            ->filters([
                // Add your filters here
            ])
            ->actions([
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
            // Add your relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouseLists::route('/'),
            // 'create' => Pages\CreateWarehouseList::route('/create'),
            // 'edit' => Pages\EditWarehouseList::route('/{record}/edit'),
        ];
    }
}