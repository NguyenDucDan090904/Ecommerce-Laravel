<?php

namespace App\Services;

use App\Models\Product;
use Exception;

class CartService
{
    public function getCart()
    {
        return session()->get('cart', []);
    }

    public function addToCart(int $productId, int $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->images->first()->path ?? null
            ];
        }

        session()->put('cart', $cart);
        return $cart;
    }

    public function updateCart(int $productId, int $quantity)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        return $cart;
    }

    public function removeFromCart(int $productId)
    {
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }
}
