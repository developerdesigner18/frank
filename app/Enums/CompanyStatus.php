<?php

namespace App\Enums;

enum CompanyStatus: string
{
    case ACTIVE = 'ACTIVE';
    case DEACTIVATE = 'DEACTIVATE';
    case BLOCKED = 'BLOCKED';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Company is active',
            self::DEACTIVATE => 'Company has been deactivated',
            self::BLOCKED => 'Company has been blocked',
        };
    }
}
