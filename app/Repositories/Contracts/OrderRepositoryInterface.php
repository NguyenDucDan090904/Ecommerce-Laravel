<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function createOrderWithItems(array $orderData, array $cartItems);
    public function getAllPaginated(int $perPage = 10);
    public function findByIdWithDetails(int $id);
    public function updateStatus(int $id, string $status);
}
