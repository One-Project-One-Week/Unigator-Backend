<?php

namespace App\Enums\University;

use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    case PRIVATE = 'private';
    case PUBLIC = 'public';

    public function getLabel(): string
    {
        return match ($this) {
            self::PRIVATE => 'Private',
            self::PUBLIC => 'Public',
        };
    }
}
