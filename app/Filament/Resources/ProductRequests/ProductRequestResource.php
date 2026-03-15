<?php

namespace App\Filament\Resources\ProductRequests;

use App\Filament\Resources\ProductRequests\Pages\CreateProductRequest;
use App\Filament\Resources\ProductRequests\Pages\EditProductRequest;
use App\Filament\Resources\ProductRequests\Pages\ListProductRequests;
use App\Filament\Resources\ProductRequests\Pages\ProcessProductRequest;
use App\Filament\Resources\ProductRequests\Pages\ViewProductRequest;
use App\Filament\Resources\ProductRequests\Schemas\ProductRequestForm;
use App\Filament\Resources\ProductRequests\Schemas\ProductRequestInfolist;
use App\Filament\Resources\ProductRequests\Tables\ProductRequestsTable;
use App\Models\ProductRequest;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductRequestResource extends Resource
{
    protected static ?string $model = ProductRequest::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ShoppingCart;

    protected static ?string $recordTitleAttribute = 'request_number';

    public static function form(Schema $schema): Schema
    {
        return ProductRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductRequests::route('/'),
            'create' => CreateProductRequest::route('/create'),
            'view' => ViewProductRequest::route('/{record}'),
            'edit' => EditProductRequest::route('/{record}/edit'),
            'process' => ProcessProductRequest::route('/{record}/process'),
        ];
    }
}
