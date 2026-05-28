<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function createOrderWithItems(array $orderData, array $cartItems);
}
