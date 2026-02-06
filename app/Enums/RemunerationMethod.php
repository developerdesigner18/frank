<?php

namespace App\Enums;

enum RemunerationMethod: string
{
    case VERLONING = 'VERLONING.NL';
    case INVOICING = 'INVOICING';

    public function label(): string
    {
        return match($this) {
            self::VERLONING => 'verloning.nl',
            self::INVOICING => 'invoicing',
        };
    }
}
