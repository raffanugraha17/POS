<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Regency;
use App\Models\ListBank;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SupplierList;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierListResource\Pages;
use App\Filament\Resources\SupplierListResource\RelationManagers;

class SupplierListResource extends Resource
{
    protected static ?string $model = SupplierList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Purchasing";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('supplier')->required(),
                TextInput::make('telephone')->required()->type('number'),
                TextInput::make('contact')->required(),
                TextInput::make('address')->required(),
                Select::make('province_id')
                ->label('Province')
                ->required()
                ->searchable()
                ->options(Province::all()->pluck('name', 'id'))
                ->reactive(),
            Select::make('regency_id')
                ->label('City')
                ->required()
                ->searchable()
                ->placeholder('Select a City')
                ->options(function (callable $get) {
                    $provinceId = $get('province_id');
                    if (!$provinceId) {
                        return [];
                    }

                    $province = Province::find($provinceId);
                    return $province->regencies->pluck('name', 'id');
                })
                ->reactive(),
            Select::make('list_bank_id')
                ->label('Bank')
                ->required()
                ->searchable()
                ->options(ListBank::all()->pluck('name', 'id'))
                ->reactive(),
            TextInput::make('npwp')->required()->type('number')->label('NPWP',)


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier')->sortable()->label('Supplier')->searchable(),
                TextColumn::make('telephone')->label('Telephone')->sortable()->searchable(),
                TextColumn::make('contact')->label('Contact')->sortable()->searchable(),
                TextColumn::make('address')->label('Address')->sortable()->searchable(),
                TextColumn::make('province.name')->label('Province')->sortable()->searchable(),
                TextColumn::make('regency.name')->label('City')->sortable()->searchable(),
                TextColumn::make('bank.name')->label('Bank')->sortable()->searchable(),
                TextColumn::make('npwp')->label('NPWP')->sortable()->searchable(),
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
            'index' => Pages\ListSupplierLists::route('/'),
            // 'create' => Pages\CreateSupplierList::route('/create'),
            // 'edit' => Pages\EditSupplierList::route('/{record}/edit'),
        ];
    }
}
