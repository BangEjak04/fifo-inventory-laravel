<?php

namespace App\Filament\Pages;

use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // protected string $view = 'filament.pages.dashboard';

    public static string|BackedEnum|null $navigationIcon = LucideIcon::Gauge;

    public function getHeaderActions(): array
    {
        return parent::getHeaderActions();
    }
}
