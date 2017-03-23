<?php
namespace Acme\Shop\Application\Controllers;

use Acme\Shop\Application\UseCases\AddItemToCart;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartElement;
use Acme\Shop\Domain\Models\Cart\CartRepository;
use Acme\Shop\Domain\Models\Item\ItemRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** @var  CartRepository */
    private $cartRepo;

    /** @var  ItemRepository */
    private $itemRepo;

    /**
     * @param CartRepository $cartRepo
     * @param ItemRepository $itemRepo
     */
    public function __construct(
        CartRepository $cartRepo,
        ItemRepository $itemRepo
    )
    {
        $this->cartRepo = $cartRepo;
        $this->itemRepo = $itemRepo;
    }

    /**
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $cart = $this->cartRepo->find();

        return response()->json(['cart' => $this->cartToArray($cart)]);
    }

    /**
     * @param Request $request
     * @param AddItemToCart $useCase
     * @return JsonResponse
     */
    public function post(Request $request, AddItemToCart $useCase): JsonResponse
    {
        $this->validate($request, [
            'item_id' => 'required|integer',
            'count' => 'required|integer'
        ]);

        $cart = $useCase(
            $request->get('item_id'),
            $request->get('count')
        );

        return response()->json(['cart' => $this->cartToArray($cart)]);
    }

    /**
     * @param Cart $cart
     * @return array
     */
    private function cartToArray(Cart $cart): array
    {
        $elements = [];
        foreach ($cart->elements() as $cartElement) {
            /** @var CartElement $cartElement */
            $elements[] = [
                'item' => [
                    'id' => $cartElement->item()->id(),
                    'name' => $cartElement->item()->name(),
                    'price' => $cartElement->item()->price(),
                ],
                'count' => $cartElement->count(),
            ];
        }

        return [
            'elements' => $elements,
            'totalCount' => $cart->count(),
            'totalPrice' => $cart->price(),
        ];
    }
}