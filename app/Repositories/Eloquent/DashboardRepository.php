<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getTotalRevenue($startDate = null, $endDate = null)
    {
        $query = Order::where('status', 'completed');
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        return $query->sum('total_amount');
    }

    public function getOrdersCount($startDate = null, $endDate = null)
    {
        $query = Order::query();
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        return $query->count();
    }

    public function getCustomersCount($startDate = null, $endDate = null)
    {
        $query = User::where('role', 'user');
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        return $query->count();
    }

    public function getRevenueDataByMonth()
    {
        return Order::where('status', 'completed')
            ->select(
                DB::raw('SUM(total_amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%m/%Y') as month")
            )
            ->groupBy('month')
            ->orderByRaw('MIN(created_at) ASC')
            ->take(6)
            ->get();
    }

    public function getTopSellingProducts(int $limit = 5)
    {
        return OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->take($limit)
            ->get();
    }
}
