<?php
namespace Acme\Shop\Application\UseCases;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartRepository;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemRepository;

class AddItemToCart
{
    /** @var  ItemRepository */
    private $itemRepo;

    /** @var  CartRepository */
    private $cartRepo;

    /**
     * @param ItemRepository $itemRepo
     * @param CartRepository $cartRepo
     */
    public function __construct(ItemRepository $itemRepo, CartRepository $cartRepo)
    {
        $this->itemRepo = $itemRepo;
        $this->cartRepo = $cartRepo;
    }

    /**
     * @param int $itemId
     * @param int $count
     * @return Cart
     */
    public function __invoke(int $itemId, int $count): Cart
    {
        $item = $this->itemRepo->findById(ItemId::of($itemId));

        try {
            $cart = $this->cartRepo->find();
        } catch (NotFoundException $e) {
            $cart = new Cart();
        }

        $cart->addItem($item, ItemCount::of($count));
        $this->cartRepo->store($cart);

        return $cart;
    }
}
