<?php

namespace App\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function getTotalRevenue($startDate = null, $endDate = null);
    public function getOrdersCount($startDate = null, $endDate = null);
    public function getCustomersCount($startDate = null, $endDate = null);
    public function getRevenueDataByMonth();
    public function getTopSellingProducts(int $limit = 5);
}
