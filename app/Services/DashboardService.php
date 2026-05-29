<?php

namespace App\Services;

use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Carbon;

class DashboardService
{
    protected $dashboardRepo;

    public function __construct(DashboardRepositoryInterface $dashboardRepo)
    {
        $this->dashboardRepo = $dashboardRepo;
    }

    public function getDashboardStats(string $timeFilter = 'this_month')
    {
        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->startOfMonth(); // Mặc định là đầu tháng này

        switch ($timeFilter) {
            case 'today':
                $startDate = Carbon::now()->startOfDay();
                break;
            case 'yesterday':
                $startDate = Carbon::now()->subDay()->startOfDay();
                $endDate = Carbon::now()->subDay()->endOfDay();
                break;
            case '7_days':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                break;
            case '30_days':
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                break;
            case 'all':
                $startDate = null;
                $endDate = null;
                break;
        }

        $revenueData = $this->dashboardRepo->getRevenueDataByMonth();

        return [
            'total_revenue' => $this->dashboardRepo->getTotalRevenue($startDate, $endDate),
            'total_orders'  => $this->dashboardRepo->getOrdersCount($startDate, $endDate),
            'total_users'   => $this->dashboardRepo->getCustomersCount($startDate, $endDate),
            'top_products'  => $this->dashboardRepo->getTopSellingProducts(),
            'chart_labels'  => $revenueData->pluck('month'),
            'chart_data'    => $revenueData->pluck('total'),
            'current_filter'=> $timeFilter // Trả lại để hiển thị trạng thái đang chọn trên giao diện
        ];
    }
}
