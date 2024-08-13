<?php

namespace App\Filament\Resources;

use Akaunting\Money\Money;
use Filament\Forms;
use Livewire\Attributes\Reactive;
use TextInput\Mask;
use App\Models\Menu;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MenuResource\Pages;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Collection;
use Filament\Support\RawJs;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = "Menu";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id')->toArray())
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set) => $set('sub_category_id', null)),
                Select::make('sub_category_id')
                    ->label('Sub Category')
                    ->required()
                    ->options(function (callable $get) {
                        $categoryId = $get('category_id');
                        if ($categoryId) {
                            $category = Category::find($categoryId);
                            if ($category && $category->subCategories) {
                                return $category->subCategories->pluck('name', 'id');
                            }
                        }
                        return [];
                    }),
                TextInput::make('menu')
                    ->required()
                    ->unique(Menu::class, 'menu', fn ($record) => $record), 
                TextInput::make('price')
                    ->label('Price')
                    ->numeric(true, 'id-ID')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->formatStateUsing(fn ($state, $record) => $state ? Money::IDR($state)->format() : ''),
                TextInput::make('stock')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->sortable()->searchable(),
                TextColumn::make('subCategory.name')->sortable()->searchable(),
                TextColumn::make('menu')->sortable()->searchable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn ($state, $record) => $state ? Money::IDR($state)->format() : ''),
                TextColumn::make('stock')->sortable()->searchable(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/admin/resources/menus'),
            // 'create' => Pages\CreateMenu::route('/create'),
            // 'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}