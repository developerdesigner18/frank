<?php
namespace App\Enums;

enum UserStatus: string
{
//    TO GET ALL USE THIS FUNCTION cases()
    case ACTIVE = 'ACTIVE';
    case DEACTIVATE = 'DEACTIVATE';
    case INVITED = 'INVITED';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'User is active',
            self::DEACTIVATE => 'User has been deactivated',
            self::INVITED => 'User has been sent invitation',
        };
    }
}
