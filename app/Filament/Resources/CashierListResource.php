<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CashierList;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CashierListResource\Pages;
use App\Filament\Resources\CashierListResource\RelationManagers;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Unique;

class CashierListResource extends Resource
{
    protected static ?string $model = CashierList::class;

    protected static ?string $navigationIcon = 'heroicon-m-server-stack';
    protected static ?string $navigationGroup = "List";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cashier_name')
                    ->required()
                    ->unique(CashierList::class, 'cashier_name', fn ($record) => $record),
                TextInput::make('cashier_telephone')
                    ->type('number')
                    ->required()
                    ->unique(CashierList::class, 'cashier_telephone', fn ($record) => $record),
                TextInput::make('cashier_role')
                    ->integer()
                    ->required()
                    ->unique(CashierList::class, 'cashier_role', fn ($record) => $record),
                Select::make('cashier_gender')
                    ->required()
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
                    ->unique(CashierList::class, 'cashier_gender', fn ($record) => $record),
                Select::make('cashier_shift')
                    ->required()
                    ->options([
                        'Morning' => 'Morning',
                        'Afternoon' => 'Afternoon',
                        'Night' => 'Night',
                    ])
                    ->unique(CashierList::class, 'cashier_shift', fn ($record) => $record),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cashier_name')->sortable()->searchable(),
                TextColumn::make('cashier_telephone')->sortable()->searchable(),
                TextColumn::make('cashier_role')->sortable()->searchable(),
                TextColumn::make('cashier_gender')->sortable()->searchable(),
                TextColumn::make('cashier_shift')->sortable()->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashierLists::route('/'),
        ];
    }

    public static function afterCreate($data, $record)
    {
        Log::info("Setting & configurations/ Cashier List created - ID: {$record->id}");
    }

    public static function afterUpdate($data, $record)
    {
        Log::info("Setting & configurations/ Cashier List updated - ID: {$record->id}");
    }

    public static function afterDelete($record)
    {
        Log::info("Setting & configurations/ Cashier List deleted - ID: {$record->id}");
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->select(['cashier_id', 'cashier_code', 'cashier_name', 'cashier_telephone', 'cashier_role', 'cashier_shift', 'cashier_gender', 'flag']);
    }
}