<?php
namespace Acme\Shop\Infrastructure\Repositories\Application\HttpSession;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartRepository;
use Illuminate\Session\Store;

final class HttpSessionCartRepository implements CartRepository
{
    const SESSION_KEY = 'cart';

    /** @var  Store */
    private $session;

    /**
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * @return Cart
     * @throws NotFoundException
     */
    public function find(): Cart
    {
        $cart = $this->session->get(static::SESSION_KEY);
        if (empty($cart)) {
            throw new NotFoundException('cart not found');
        }

        return $cart;
    }

    /**
     * @param Cart $cart
     * @return void
     */
    public function store(Cart $cart)
    {
        $this->session->put(static::SESSION_KEY, $cart);
    }
}
