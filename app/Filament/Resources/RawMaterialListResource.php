<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RawMaterialList;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RawMaterialListResource\Pages;
use App\Filament\Resources\RawMaterialListResource\RelationManagers;
use Illuminate\Support\Collection;
use Filament\Support\RawJs;
use Akaunting\Money\Money;

class RawMaterialListResource extends Resource
{
    protected static ?string $model = RawMaterialList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Purchasing";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('raw_material')->label('Raw Material'),
                Select::make('package')->label('Package')->required()
                    ->options([
                    
                    ]),
                Select::make('category')->label('Category')
                    ->options([
                       
                    ]),
                Select::make('type')->label('Type')
                    ->options([
                       
                    ]),
                Select::make('unit')->label('Unit')
                    ->options([
                        
                    ]),
                Select::make('volume')->label('Volume')
                    ->options([
                        
                    ]),
                    TextInput::make('price')
                    ->label('Price')
                    ->numeric(true, 'id-ID')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->formatStateUsing(fn ($state, $record) => $state ? Money::IDR($state)->format() : ''),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')->sortable()->label('Category')->searchable(),
                TextColumn::make('raw_material')->label('Raw Material')->sortable()->searchable(),
                TextColumn::make('package')->label('Package')->sortable()->searchable(),
                TextColumn::make('type')->label('Type')->sortable()->searchable(),
                TextColumn::make('unit')->label('Unit')->sortable()->searchable(),
                TextColumn::make('volume')->label('Volume')->sortable()->searchable(),
                TextColumn::make('price')
                ->label('Price')
                ->formatStateUsing(fn ($state, $record) => $state ? Money::IDR($state)->format() : ''),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRawMaterialLists::route('/'),
            // 'create' => Pages\CreateRawMaterialList::route('/create'),
            // 'edit' => Pages\EditRawMaterialList::route('/{record}/edit'),
        ];
    }
}