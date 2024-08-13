<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Outlet;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OutletResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use App\Filament\Resources\OutletResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Forms\Components\Select;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('outlet_logo')->required(),
                TextInput::make('outlet_name')->required()->unique(Outlet::class, 'outlet_name', fn ($record) => $record),
                TextInput::make('outlet_telephone')->type('number')->required()->maxLength(200)->unique(Outlet::class, 'outlet_telephone', fn ($record) => $record),
                TextInput::make('outlet_address')->required()->unique(Outlet::class, 'outlet_address', fn ($record) => $record),
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
                SpatieMediaLibraryImageColumn::make('outlet_logo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('outlet_name')->sortable()->searchable(),
                TextColumn::make('outlet_telephone')->sortable()->searchable(),
                TextColumn::make('outlet_address')->sortable()->searchable(),
                TextColumn::make('province.name')->label('Province')->sortable()->searchable(),
                TextColumn::make('regency.name')->label('City')->sortable()->searchable(),
                TextColumn::make('district.name')->label('District')->sortable()->searchable(),
                TextColumn::make('village.name')->label('Sub District')->sortable()->searchable(),
            ])
            ->filters([
                // Add filters here if needed
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
            // Add relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutlets::route('/'),
            // 'create' => Pages\CreateOutlet::route('/create'),
            // 'edit' => Pages\EditOutlet::route('/{record}/edit'),
        ];
    }
}