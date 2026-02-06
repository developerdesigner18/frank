<?php

namespace App\Enums;

enum AssignmentStatus: string
{
    case PENDING = 'PENDING';
    case ACCEPTED = 'ACCEPTED';
    case REJECTED = 'REJECTED';
    case COMPLETED = 'COMPLETED';
}
