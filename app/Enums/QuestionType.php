<?php

namespace App\Enums;

enum QuestionType: string
{
    case RADIO = 'RADIO';
    case SLIDER = 'SLIDER';
    case SELECT = 'SELECT';
    case AMOUNT = 'AMOUNT';
    case TEXT = 'TEXT';
    case COMMENT = 'COMMENT';
}
