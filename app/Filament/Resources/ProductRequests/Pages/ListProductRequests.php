<?php

namespace App\Filament\Resources\ProductRequests\Pages;

use App\Filament\Resources\ProductRequests\ProductRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductRequests extends ListRecords
{
    protected static string $resource = ProductRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
