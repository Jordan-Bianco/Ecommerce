<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'Pending';
    case Paid = 'Paid';
    case Failed = 'Failed';
}
