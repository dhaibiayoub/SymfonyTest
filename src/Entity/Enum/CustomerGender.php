<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum CustomerGender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';
}
