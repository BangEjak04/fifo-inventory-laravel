<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('product.columns.name')),
                TextEntry::make('code')
                    ->label(__('product.columns.code'))
                    ->fontFamily(FontFamily::Mono),
                TextEntry::make('type')
                    ->label(__('product.columns.type'))
                    ->formatStateUsing(fn ($state) => __('product.enums.type.' . $state))
                    ->badge(),
                TextEntry::make('created_at')
                    ->label(__('product.columns.created_at'))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label(__('product.columns.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
