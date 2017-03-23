<?php
namespace Acme\Shop\Domain\Models\Cart;

interface CartRepository
{
    /**
     * @return Cart
     */
    public function find(): Cart;

    /**
     * @param Cart $cart
     * @return void
     */
    public function store(Cart $cart);
}
