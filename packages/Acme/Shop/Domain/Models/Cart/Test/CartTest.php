<?php
namespace Acme\Shop\Test\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartTotalCount;
use Acme\Shop\Domain\Models\Cart\CartTotalPrice;
use Acme\Shop\Domain\Models\Cart\Test\FakeItem;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;

class CartTest extends \PHPUnit_Framework_TestCase
{
    use FakeItem;

    /**
     * @var Cart
     */
    private $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Cart();
        $this->sut->addItem($this->item(), ItemCount::of(1));
        $this->sut->addItem($this->item([
            'id' => 2,
            'name' => '商品名2',
            'price' => 200,
            'stock' => 10
        ]), ItemCount::of(2));
    }

    /**
     * @test
     */
    public function 商品追加()
    {
        $this->sut->addItem($this->item([
            'id' => 3,
            'name' => '商品名3',
            'price' => 300,
            'stock' => 1
        ]), ItemCount::of(1));

        $this->assertEquals(CartTotalCount::of(4), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(800), $this->sut->price());
    }

    /**
     * @test
     */
    public function 商品追加_カートにある商品を追加してもカート要素は増えない()
    {
        $this->sut->addItem($this->item(), ItemCount::of(2));

        $this->assertEquals(2, $this->sut->elements()->count());
        $this->assertEquals(CartTotalCount::of(5), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(700), $this->sut->price());
    }

    /**
     * @test
     */
    public function 商品削除()
    {
        $this->sut->removeItem(ItemId::of(1));

        $this->assertEquals(CartTotalCount::of(2), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(400), $this->sut->price());
    }

    /**
     * @test
     */
    public function 商品削除_空にする()
    {
        $this->sut->removeItem(ItemId::of(1));
        $this->sut->removeItem(ItemId::of(2));

        $this->assertEquals(CartTotalCount::of(0), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(0), $this->sut->price());
    }

    /**
     * @test
     */
    public function 商品削除_存在しない商品を削除()
    {
        $this->sut->removeItem(ItemId::of(999));

        $this->assertEquals(CartTotalCount::of(3), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(500), $this->sut->price());
    }

    /**
     * @test
     */
    public function カートを空にする()
    {
        $this->sut->clear();

        $this->assertEquals(CartTotalCount::of(0), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(0), $this->sut->price());
    }

    /**
     * @test
     */
    public function 商品数を変更()
    {
        $this->sut->updateItemCount(ItemId::of(1), ItemCount::of(3));

        $this->assertEquals(CartTotalCount::of(5), $this->sut->count());
        $this->assertEquals(CartTotalPrice::of(700), $this->sut->price());
    }

    /**
     * @test
     * @expectedException \Acme\Shop\Domain\Exceptions\NotFoundException
     */
    public function 商品が存在しなければエラー()
    {
        $this->sut->updateItemCount(ItemId::of(99), ItemCount::of(1));
    }
}
