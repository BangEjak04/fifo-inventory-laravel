<?php

namespace App\Filament\Resources\ProductRequests\Pages;

use App\Filament\Resources\ProductRequests\ProductRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProductRequest extends ViewRecord
{
    protected static string $resource = ProductRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
