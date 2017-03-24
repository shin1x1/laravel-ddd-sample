<?php
namespace Acme\Shop\Domain\Models\Item;

final class Item
{
    /** @var ItemId */
    private $id;

    /** @var string */
    private $name;

    /** @var ItemPrice */
    private $price;

    /** @var  Stock */
    private $stock;

    /**
     * @param ItemId $id
     * @param string $name
     * @param ItemPrice $price
     * @param Stock $stock
     */
    public function __construct(ItemId $id, string $name, ItemPrice $price, Stock $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    /**
     * @param ItemCount $count
     * @return bool
     */
    public function isStockSufficient(ItemCount $count): bool
    {
        return $this->stock()->isSufficient($count);
    }

    public function id(): ItemId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): ItemPrice
    {
        return $this->price;
    }

    public function stock(): Stock
    {
        return $this->stock;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function equals(self $item): bool
    {
        return $this->id()->equals($item->id());
    }
}
