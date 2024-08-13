<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentMethod;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Filament\Resources\PaymentMethodResource\RelationManagers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use Illuminate\Validation\Rules\Unique;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;
    protected static ?string $navigationIcon = 'heroicon-s-square-2-stack';
    protected static ?string $navigationGroup = "Setting & configurations";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('payment_method')
                    ->required()
                    ->unique(PaymentMethod::class, 'payment_method', fn ($record) => $record),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_method')->sortable()->searchable(),
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
            'index' => Pages\ListPaymentMethods::route('/'),
            // 'create' => Pages\CreatePaymentMethod::route('/create'),
            // 'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->select(['payment_method_id', 'payment_method_code', 'payment_method', 'flag']);
    }

    public static function afterCreate($data, $record)
    {
        $userId = Auth::id();
        ActivityLog::create([
            'user_id' => $userId,
            'activity' => 'created',
            'module' => 'Payment Method',
            'table' => 'payment_methods',
            'record_id' => $record->id,
        ]);

        Log::info("Setting & configurations/ Payment Method created - ID: {$record->id}");
    }

    public static function afterUpdate($data, $record)
    {
        $userId = Auth::id();
        ActivityLog::create([
            'user_id' => $userId,
            'activity' => 'updated',
            'module' => 'Payment Method',
            'table' => 'payment_methods',
            'record_id' => $record->id,
        ]);

        Log::info("Setting & configurations/ Payment Method updated - ID: {$record->id}");
    }

    public static function afterDelete($record)
    {
        $userId = Auth::id();
        ActivityLog::create([
            'user_id' => $userId,
            'activity' => 'deleted',
            'module' => 'Payment Method',
            'table' => 'payment_methods',
            'record_id' => $record->id,
        ]);

        Log::info("Setting & configurations/ Payment Method deleted - ID: {$record->id}");
    }
}