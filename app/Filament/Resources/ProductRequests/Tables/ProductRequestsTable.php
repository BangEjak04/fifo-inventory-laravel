<?php

namespace App\Filament\Resources\ProductRequests\Tables;

use App\Models\ProductRequest;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('request_number'),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => __('product.request.enums.type.'.$state))
                    ->colors([
                        'success' => 'sale',
                        'warning' => 'return',
                        'danger' => 'destroy',
                    ]),
                TextColumn::make('status')
                    ->formatStateUsing(fn ($state) => __('product.request.enums.status.'.$state))
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'primary' => 'approved',
                        'warning' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('process')
                        ->url(fn (ProductRequest $record): string => route('filament.app.resources.product-requests.process', $record)),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
