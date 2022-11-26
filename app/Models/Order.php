<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function scopeWithSortBy($query, $sortBy)
    {
        $query->when($sortBy, function ($query) use ($sortBy) {
            switch ($sortBy) {
                case 'total_desc':
                    $query->orderBy('total', 'desc');
                    break;
                case 'total_asc':
                    $query->orderBy('total', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        });
    }

    public function scopeWithDashboardData($query)
    {
        $query
            ->selectRaw('
                sum(total) as total_spent,
                COUNT(*) as orders_placed,
                ROUND(avg(total), 2) as avg_expense,
                MAX(total) as max_expense
            ')
            ->groupBy('orders.user_id');
    }

    public function scopeWithTimespan($query, $timespan)
    {
        switch ($timespan) {
            case 'current_week':
                $period = CarbonPeriod::between(
                    now()->startOfWeek(),
                    now()
                );

                $query->whereBetween('created_at', [$period->getStartDate(), $period->getEndDate()]);
                break;

            case 'last_week':
                $period = CarbonPeriod::between(
                    now()->subDays(7)->startOfWeek(),
                    now()->subDays(7)->endOfWeek()
                );

                $query->whereBetween('created_at', [$period->getStartDate(), $period->getEndDate()]);
                break;

            case 'last_month':
                $period = CarbonPeriod::between(
                    now()->subDays(30)->startOfMonth(),
                    now()->subDays(30)->endOfMonth()
                );

                $query->whereBetween('created_at', [$period->getStartDate(), $period->getEndDate()]);
                break;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot(['quantity', 'unit_price'])
            ->withTimestamps();
    }

    public function detail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }
}
