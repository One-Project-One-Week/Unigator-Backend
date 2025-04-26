<?php

namespace App\Enums\Program;

use Filament\Support\Contracts\HasLabel;

enum PaymentType: string implements HasLabel
{
    case MONTHLY = 'monthly';
    case PER_SEMESTER = 'per_semester';
    case NO_INSTALLEMENTS = 'no_installements';

    public function getLabel(): string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly',
            self::PER_SEMESTER => 'Per Semester',
            self::NO_INSTALLEMENTS => 'No Installements',
        };
    }
}