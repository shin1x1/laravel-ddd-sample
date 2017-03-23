<?php
namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Exceptions\InvariantException;
use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;
use Illuminate\Support\Collection;

final class Cart
{
    /** @var CartElement[]|Collection */
    private $elements;

    /** @var CartTotalCount */
    private $totalCount;

    /** @var CartTotalPrice */
    private $totalPrice;

    public function __construct()
    {
        $this->clear();
    }

    /**
     * @param Item $item
     * @param ItemCount $count
     * @throws InvariantException
     */
    public function addItem(Item $item, ItemCount $count)
    {
        if (!$item->isStockSufficient($count)) {
            throw new InvariantException('stock is insufficient');
        }

        $element = $this->findItem($item->id());
        if (is_null($element)) {
            $this->elements->push(new CartElement($item, $count));
            return;
        }

        $element->addCount($count);
    }

    /**
     * @return CartTotalCount
     */
    public function count(): CartTotalCount
    {
        return $this->elements->reduce(function (CartTotalCount $total, CartElement $element) {
            return $total->add($element->count());
        }, CartTotalCount::of(0));
    }

    /**
     * @return CartTotalPrice
     */
    public function price(): CartTotalPrice
    {
        return $this->elements->reduce(function (CartTotalPrice $total, CartElement $e) {
            return $total->add($e->price());
        }, CartTotalPrice::of(0));
    }

    /**
     *
     */
    public function clear()
    {
        $this->elements = new Collection();
        $this->totalCount = CartTotalCount::of();
        $this->totalPrice = CartTotalPrice::of();
    }

    /**
     * @param ItemId $id
     */
    public function removeItem(ItemId $id)
    {
        $this->elements = $this->elements->filter(function (CartElement $e) use ($id) {
            return !$e->match($id);
        });
    }

    /**
     * @param ItemId $id
     * @param ItemCount $count
     * @throws NotFoundException
     */
    public function updateItemCount(ItemId $id, ItemCount $count)
    {
        $element = $this->findItem($id);
        if (is_null($element)) {
            throw new NotFoundException(sprintf('Item %d is not found', $id->value()));
        }

        $element->updateCount($count);
    }

    /**
     * @param ItemId $id
     * @return CartElement
     */
    private function findItem(ItemId $id): ?CartElement
    {
        return $this->elements->first(function (CartElement $e) use ($id) {
            return $e->match($id);
        }, null);
    }

    /**
     * @return Collection
     */
    public function elements(): Collection
    {
        return clone $this->elements;
    }
}
