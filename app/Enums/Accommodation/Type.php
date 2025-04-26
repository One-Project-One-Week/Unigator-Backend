<?php

namespace App\Enums\Accommodation;

use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    case DORM = 'dorm';
    case PRIVATE_RENTAL = 'private-rental';

    public function getLabel(): string
    {
        return match ($this) {
            self::DORM => 'Dorm',
            self::PRIVATE_RENTAL => 'Private Rental',
        };
    }
}