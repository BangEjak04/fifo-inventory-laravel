<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum NavigationGroup: string implements HasLabel
{
    case MANAGEMENT = 'management';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::MANAGEMENT => __('navigation-group.management')
        };
    }
}
