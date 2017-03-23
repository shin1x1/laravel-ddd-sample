<?php
namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemSubtotal;
use Illuminate\Contracts\Support\Arrayable;

class CartElement implements Arrayable
{
    /** @var Item */
    private $item;

    /** @var ItemCount */
    private $count;

    /**
     * @param Item $item
     * @param ItemCount $count
     */
    public function __construct(Item $item, ItemCount $count)
    {
        $this->item = $item;
        $this->count = $count;
    }

    /**
     * @return Item
     */
    public function item(): Item
    {
        return $this->item;
    }

    /**
     * @return ItemCount
     */
    public function count(): ItemCount
    {
        return $this->count;
    }

    /**
     * @return ItemSubtotal
     */
    public function price(): ItemSubtotal
    {
        return $this->item->price()->calcSubtotal($this->count);
    }

    /**
     * @param ItemCount $count
     */
    public function updateCount(ItemCount $count)
    {
        $this->count = $count;
    }

    /**
     * @param ItemCount $count
     */
    public function addCount(ItemCount $count)
    {
        $this->count = $this->count->add($count);
    }

    /**
     * @param ItemId $id
     * @return bool
     */
    public function match(ItemId $id): bool
    {
        return $this->item()->id()->equals($id);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $item = $this->item()->toArray();

        return [
            'item' => [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
            ],
            'count' => $this->count()->value(),
        ];
    }
}
