<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\AdminOrderService;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $adminOrderService;

    public function __construct(OrderRepositoryInterface $orderRepo, AdminOrderService $adminOrderService)
    {
        $this->orderRepo = $orderRepo;
        $this->adminOrderService = $adminOrderService;
    }

    public function index()
    {
        $orders = $this->orderRepo->getAllPaginated(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderRepo->findByIdWithDetails($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, $id)
    {
        try {
            $this->adminOrderService->changeStatus($id, $request->status);
            return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
