<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Shift;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ShiftResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Unique;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;
    protected static ?string $navigationIcon = 'heroicon-c-users';
    protected static ?string $navigationGroup = "Setting & configurations";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('shift_name')
                    ->required()
                    ->unique(Shift::class, 'shift_name', fn ($record) => $record),
                TimePickerField::make('start_shift')
                    ->label('Start Shift')
                    ->okLabel("Confirm")
                    ->cancelLabel("Cancel")
                    ->required()
                    ->unique(Shift::class, 'start_shift', fn ($record) => $record),
                TimePickerField::make('end_shift')
                    ->label('End Shift')
                    ->okLabel("Confirm")
                    ->cancelLabel("Cancel")
                    ->required()
                    ->unique(Shift::class, 'end_shift', fn ($record) => $record),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shift_name')->sortable()->searchable(),
                TextColumn::make('start_shift')->sortable()->searchable(),
                TextColumn::make('end_shift')->sortable()->searchable(),
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
            'index' => Pages\ListShifts::route('/'),
        ];
    }

    public static function afterCreate($data, $record)
    {
        Log::info("Setting & configurations/ Shift created - ID: {$record->id}");
    }

    public static function afterUpdate($data, $record)
    {
        Log::info("Setting & configurations/ Shift updated - ID: {$record->id}");
    }

    public static function afterDelete($record)
    {
        Log::info("Setting & configurations/ Shift deleted - ID: {$record->id}");
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes();
    }
}