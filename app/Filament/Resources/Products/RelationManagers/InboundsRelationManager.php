<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Enums\ProductionSession;
use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class InboundsRelationManager extends RelationManager
{
    protected static string $relationship = 'inbounds';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('product.inbound.model.label');
    }

    public static function getModelLabel(): ?string
    {
        return __('product.inbound.model.label');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('production_date')
                    ->label(__('product.inbound.columns.production_date'))
                    ->default(now())
                    ->required(),
                Select::make('session')
                    ->label(__('product.inbound.columns.session'))
                    ->options(ProductionSession::class)
                    ->required(),
                TextInput::make('quantity_in')
                    ->label(__('product.inbound.columns.quantity_in'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('production_date')
                    ->label(__('product.inbound.columns.production_date'))
                    // ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->translatedFormat('d F Y') : '-')
                    ->date(),
                TextEntry::make('session')
                    ->label(__('product.inbound.columns.session')),
                TextEntry::make('quantity_in')
                    ->label(__('product.inbound.columns.quantity_in'))
                    ->numeric(),
                TextEntry::make('quantity_remaining')
                    ->label(__('product.inbound.columns.quantity_remaining'))
                    ->numeric(),
                TextEntry::make('barcode')
                    ->label(__('product.inbound.columns.barcode')),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('production_date')
                    ->label(__('product.inbound.columns.production_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('session')
                    ->label(__('product.inbound.columns.session'))
                    ->searchable(),
                TextColumn::make('quantity_in')
                    ->label(__('product.inbound.columns.quantity_in'))
                    ->numeric()
                    ->badge()
                    ->sortable(),
                TextColumn::make('quantity_remaining')
                    ->label(__('product.inbound.columns.quantity_remaining'))
                    ->numeric()
                    ->badge()
                    ->sortable(),
                TextColumn::make('barcode')
                    ->label(__('product.inbound.columns.barcode'))
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
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $product = $this->getOwnerRecord();
                        $productCode = $product->code;
                        $productionDate = Carbon::parse($data['production_date'])->format('dmY');
                        $productionSession = $data['session'] instanceof ProductionSession ? $data['session']->value : $data['session'];

                        $data['barcode'] = $productCode.$productionDate.$productionSession.$data['quantity_in'];

                        $data['quantity_remaining'] = $data['quantity_in'];

                        return $data;
                    }),
                // AssociateAction::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    // DissociateAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
