<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withSum('inbounds', 'quantity_remaining'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('product.columns.name'))
                    ->searchable(),
                TextColumn::make('inbounds_sum_quantity_remaining')
                    ->label(__('product.columns.stock'))
                    ->badge()
                    ->color(function ($state) {
                        if ($state == 0 || $state == null) return 'danger';
                        if ($state < 10) return 'warning';
                        return 'success';
                    }),
                TextColumn::make('type')
                    ->label(__('product.columns.type'))
                    ->formatStateUsing(fn ($state) => __('product.enums.type.'.$state))
                    ->badge(),
                TextColumn::make('code')
                    ->label(__('product.columns.code'))
                    ->fontFamily(FontFamily::Mono)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('product.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('product.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
