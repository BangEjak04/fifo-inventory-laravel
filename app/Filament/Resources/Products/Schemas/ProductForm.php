<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('product.columns.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label(__('product.columns.code'))
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('type')
                    ->label(__('product.columns.type'))
                    ->options(ProductType::class)
                    ->required(),
            ]);
    }
}
