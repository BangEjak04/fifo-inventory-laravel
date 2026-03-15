<?php

namespace App\Filament\Resources\ProductRequests\Pages;

use App\Enums\RequestStatus;
use App\Filament\Resources\ProductRequests\ProductRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductRequest extends CreateRecord
{
    protected static string $resource = ProductRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['request_number'] = 'REQ-'.now()->format('YmdHis');

        $data['created_by'] = auth()->id();

        $data['status'] = RequestStatus::DRAFT;

        return parent::mutateFormDataBeforeCreate($data);
    }
}
