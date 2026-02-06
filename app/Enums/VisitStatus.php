<?php

namespace App\Enums;

enum VisitStatus: string
{
    case OPEN = 'OPEN';
    case INTERESTED = 'INTERESTED';
    case ASSIGNED = 'ASSIGNED';
    case VISITED = 'VISITED';
    case SCHEDULED = 'SCHEDULED';
    case IN_PROGRESS = 'IN_PROGRESS';
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case APPROVED = 'APPROVED';
}
