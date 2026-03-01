<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProductionSession: string implements HasLabel
{
    case MORNING = '01';
    case AFTERNOON = '02';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this)
        {
            self::MORNING => __('product.inbound.enums.session.morning'),
            self::AFTERNOON => __('product.inbound.enums.session.afternoon'),
        };
    }
}
