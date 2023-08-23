<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use function Ramsey\Collection\remove;

class CartController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {

        return view('cart.index');
    }

    /**
     * @param Request $request
     * @param string $productSlug
     */
    public function add(Request $request, Product $product)
    {

        Cart::instance('cart')->add(
            $product,
            $request->get('quantity', 1),
        );

        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $data = $request->validate([
           'rowId' => ['required', 'string']
        ]);

        Cart::instance('cart')->remove($data['rowId']);

        return redirect()->back();

    }

    /**
     * @param Request $request
     */
    public function countUpdate(Request $request)
    {
    }


}
