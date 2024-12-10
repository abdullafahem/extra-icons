<?php

namespace FahemDev\ExtraIcons;

use Filament\Contracts\Plugin;

class ExtraIcons implements Plugin
{
    public static function make(): ExtraIcons
    {
        return new ExtraIcons();
    }

    public function getId(): string
    {
        return 'extra-icons';
    }

    public function register(\Filament\Panel $panel): void
    {
        // No additional registration logic needed
    }

    public function boot(\Filament\Panel $panel): void
    {
        // No extra logic needed
    }
}
