<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProductType: string implements HasLabel
{
    case DRY = 'dry';
    case WET = 'wet';
    
    public function getLabel(): string|Htmlable|null
    {
        return match ($this)
        {
            self::DRY => __('product.enums.type.dry'),
            self::WET => __('product.enums.type.wet')
        };
    }
}
