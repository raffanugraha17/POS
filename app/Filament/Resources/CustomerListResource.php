<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerList;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use PhpParser\Node\Stmt\Label;
use Filament\Resources\Resource;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerListResource\Pages;
use App\Filament\Resources\CustomerListResource\RelationManagers;


class CustomerListResource extends Resource
{
    protected static ?string $model = CustomerList::class;

    protected static ?string $navigationIcon = 'heroicon-m-server-stack';
    protected static ?string $navigationGroup = "List";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('Photo')->required(),
                Select::make('membership_id')
                    ->label('Membership')
                    ->relationship('membership', 'name'),  
                TextInput::make('customer_name')
                    ->label('Name')
                    ->required(),
                Select::make('customer_gender')
                    ->required()
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]), 
                TextInput::make('customer_telephone')
                    ->type('number')
                    ->required()
                    ->maxLength(200)
                    ->label('WhatsApp'),
                DatePicker::make('birth_date')
                    ->format('Y/m/d')
                    ->required(),
                TextInput::make('customer_occupation')
                    ->required()
                    ->label('Occupation'),
                TextInput::make('customer_address')
                    ->required()
                    ->Label('Address'),
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
                Select::make('district_id')
                    ->label('District')
                    ->required()
                    ->searchable()
                    ->placeholder('Select a District')
                    ->options(function (callable $get) {
                        $regencyId = $get('regency_id');
                        if (!$regencyId) {
                            return [];
                        }

                        $regency = Regency::find($regencyId);
                        return $regency->districts->pluck('name', 'id');
                    })
                    ->reactive(),
                Select::make('village_id')
                    ->label('Sub District')
                    ->required()
                    ->searchable()
                    ->placeholder('Select a Sub District')
                    ->options(function (callable $get) {
                        $districtId = $get('district_id');
                        if (!$districtId) {
                            return [];
                        }

                        $district = District::find($districtId);
                        return $district->villages->pluck('name', 'id');
                    }),
                   
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('membership.name')->sortable()->searchable(),
                TextColumn::make('customer_name')->sortable()->searchable(),
                TextColumn::make('customer_telephone')->label('WhatsApp')->sortable()->searchable(),
                TextColumn::make('birth_date')->sortable()->searchable(),
                TextColumn::make('customer_gender')->sortable()->searchable(),
                TextColumn::make('customer_occupation')->sortable()->searchable(),
                TextColumn::make('customer_address')->sortable()->searchable(),
                TextColumn::make('province.name')->label('Province')->sortable()->searchable(),
                TextColumn::make('regency.name')->label('City')->sortable()->searchable(),
                TextColumn::make('district.name')->label('District')->sortable()->searchable(),
                TextColumn::make('village.name')->label('Sub District')->sortable()->searchable(),
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
            'index' => Pages\ListCustomerLists::route('/'),
        ];
    }

    public static function afterCreate($data, $record)
    {
        Log::info("Setting & configurations/ Customer List created - ID: {$record->id}");
    }

    public static function afterUpdate($data, $record)
    {
        Log::info("Setting & configurations/ Customer List updated - ID: {$record->id}");
    }

    public static function afterDelete($record)
    {
        Log::info("Setting & configurations/ Customer List deleted - ID: {$record->id}");
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->select(['customer_id', 'membership_id', 'customer_code', 'customer_name', 'customer_telephone', 'birth_date', 'customer_occupation', 'customer_address', 'customer_gender', 'flag']);
    }
}