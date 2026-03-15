<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum RequestType: string implements HasLabel
{
    case SALE = 'sale';
    case RETURN = 'return';
    case REMOVE = 'remove';


    public function getLabel(): string|Htmlable|null
    {
        return match ($this)
        {
            self::SALE => __('product.request.enums.type.sale'),
            self::RETURN => __('product.request.enums.type.return'),
            self::REMOVE => __('product.request.enums.type.remove')
        };
    }
}
