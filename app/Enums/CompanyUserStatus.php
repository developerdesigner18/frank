<?php

namespace App\Enums;

enum CompanyUserStatus: string
{
    case ACTIVE = 'ACTIVE';
    case DEACTIVATE = 'DEACTIVATE';
    case BLOCKED = 'BLOCKED';
    case INVITED = 'INVITED';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Company User is active',
            self::DEACTIVATE => 'Company User has been deactivated',
            self::BLOCKED => 'Company User has been blocked',
            self::INVITED => 'Company User has been Invited',
        };
    }
}
