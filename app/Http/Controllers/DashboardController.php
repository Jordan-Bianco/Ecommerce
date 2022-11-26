<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->withDashboardData()
            ->withTimespan($request->timespan ?? 'current_week')
            ->first();

        $lastOrder = auth()->user()
            ->orders()
            ->latest()
            ->with('products')
            ->first();


        $chartData = $this->getChartData($request->timespan ?? 'current_week');

        return inertia('Dashboard/Overview', [
            'orders' => $orders,
            'lastOrder' => $lastOrder,
            'timespan' => $request->timespan ?? 'current_week',
            'chartData' => $chartData,
        ]);
    }

    protected function getChartData($timespan)
    {
        switch ($timespan) {
            case 'current_week':
                $data = $this->getCurrentWeekData();
                break;

            case 'last_week':
                $data = $this->getLastWeekData();
                break;

            case 'last_month':
                $data = $this->getLastMonthData();
                break;
        }

        return [
            'data' => $data,
        ];
    }

    protected function getCurrentWeekData()
    {
        $period = CarbonPeriod::between(
            now()->startOfWeek(),
            now()
        );

        return $this->getData($period);
    }

    protected function getLastWeekData()
    {
        $period = CarbonPeriod::between(
            now()->subDays(7)->startOfWeek(),
            now()->subDays(7)->endOfWeek()
        );

        return $this->getData($period);
    }

    protected function getLastMonthData()
    {
        $period = CarbonPeriod::between(
            now()->subDays(30)->startOfMonth(),
            now()->subDays(30)->endOfMonth()
        );

        return $this->getData($period);
    }

    protected function getData($period)
    {
        $days = [];

        foreach ($period as $date) {
            $days[] = [
                'day' => $date->toDateString(),
                'total_spent' => 0,
                'user_id' => auth()->id()
            ];
        }

        $total = Order::query()
            ->selectRaw('
                CAST(created_at as DATE) as day,
                SUM(total) as total_spent,
                user_id
            ')
            ->whereBetween('created_at', [$period->getStartDate(), $period->getEndDate()])
            ->groupBy('user_id', 'day')
            ->having('user_id', auth()->id())
            ->get();

        return collect($days)->merge($total)
            ->groupBy('day')
            ->map(function ($sub) {
                return [
                    'day' => $sub->first()['day'],
                    'total_spent' => $sub->sum('total_spent'),
                    'user_id' => $sub->first()['user_id']
                ];
            })
            ->sortBy('day')
            ->values();
    }
}
