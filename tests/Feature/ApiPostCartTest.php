<?php

namespace Tests\Feature;

use Acme\Shop\Infrastructure\Eloquents\EloquentItem;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApiPostCartTest extends TestCase
{
    /**
     * @test
     */
    public function ok()
    {
        $response = $this->post('/api/cart', [
            'item_id' => 1,
            'count' => 2,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $item = EloquentItem::find(1);
        $response->assertJson([
            'cart' => [
                'elements' => [
                    [
                        'item' => [
                            'id' => 1,
                            'name' => $item->name,
                            'price' => $item->price,
                        ],
                        'count' => 2,
                    ],
                ],
                'totalCount' => 2,
                'totalPrice' => $item->price * 2,
            ],
        ]);
    }

    /**
     * @test
     */
    public function 連続してカートに入れる()
    {
        $this->session([])
            ->post('/api/cart', [
                'item_id' => 1,
                'count' => 2,
            ]);

        $response = $this->session($this->app['session']->all())
            ->post('/api/cart', [
                'item_id' => 1,
                'count' => 1,
            ]);

        $response->assertStatus(Response::HTTP_OK);

        $item = EloquentItem::find(1);
        $response->assertJson([
            'cart' => [
                'elements' => [
                    [
                        'item' => [
                            'id' => 1,
                            'name' => $item->name,
                            'price' => $item->price,
                        ],
                        'count' => 3,
                    ],
                ],
                'totalCount' => 3,
                'totalPrice' => $item->price * 3,
            ],
        ]);
    }

    /**
     * @test
     */
    public function パラメータ無し()
    {
        $response = $this->post('/api/cart');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('item_id', $errors);
        $this->assertArrayHasKey('count', $errors);
    }

    /**
     * @test
     */
    public function 商品が存在しない()
    {
        $response = $this->post('/api/cart', [
            'item_id' => 999,
            'count' => 2,
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function 在庫が不足している()
    {
        $item = EloquentItem::find(1);
        $response = $this->post('/api/cart', [
            'item_id' => 1,
            'count' => $item->stock + 1,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            'error' => 'stock is insufficient'
        ]);
    }
}
