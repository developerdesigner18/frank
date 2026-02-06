<?php

namespace App\Enums;

enum ReportStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case UNDER_REVIEW = 'UNDER_REVIEW';
    case COMPLETED = 'COMPLETED';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
}
