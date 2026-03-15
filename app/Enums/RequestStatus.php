<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum RequestStatus: string implements HasLabel
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this)
        {
            self::DRAFT => __('product.request.enums.status.draft'),
            self::APPROVED => __('product.request.enums.status.approved'),
            self::PROCESSING => __('product.request.enums.status.processing'),
            self::COMPLETED => __('product.request.enums.status.completed'),
            self::CANCELLED => __('product.request.enums.status.cancelled')
        };
    }
}
