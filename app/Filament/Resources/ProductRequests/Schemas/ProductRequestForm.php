<?php

namespace App\Filament\Resources\ProductRequests\Schemas;

use App\Enums\RequestStatus;
use App\Enums\RequestType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(RequestType::class)
                    ->native(false),
                Select::make('status')
                    ->options(RequestStatus::class)
                    ->native(false),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->distinct()
                            ->required(),
                        TextInput::make('quantity_requested')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1),
                    ])
                    ->minItems(1)
                    ->columns(2)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
