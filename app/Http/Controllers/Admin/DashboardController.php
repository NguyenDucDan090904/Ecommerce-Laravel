<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        // Lấy filter từ request, nếu không có thì mặc định là 'this_month'
        $filter = $request->get('filter', 'this_month');

        $data = $this->dashboardService->getDashboardStats($filter);
        return view('admin.dashboard', $data);
    }
}
