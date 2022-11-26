<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Unpaid = 'Unpaid';
    case Paid = 'Paid';
    case Shipped = 'Shipped';
    case Completed = 'Completed';
    case Canceled = 'Canceled';
}
