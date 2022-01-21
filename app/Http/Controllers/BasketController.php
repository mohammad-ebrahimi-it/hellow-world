<?php

namespace App\Http\Controllers;

use App\Exceptions\QuantityExceededException;
use App\Models\Product;
use App\Support\Basket\Basket;
use App\Support\Payment\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    private $basket;
    /**
     * @var Transaction
     */
    protected $transaction;

    public function __construct(Basket $basket, Transaction $transaction)
    {
        $this->middleware('auth')->only(['checkoutForm']);
        $this->basket = $basket;
        $this->transaction = $transaction;
    }

    public function index()
    {
        $items = $this->basket->all();
        return view('basket', compact('items'));
    }

    public function add(Product $product): RedirectResponse
    {
        try {
            $this->basket->add($product, 1);
            return back()->with('addToBasket', __('payment.added to basket'));
        } catch (QuantityExceededException $e) {
            return back()->with('quantityExceeded', __('payment.quantity exceeded'));
        }
    }


    /**
     * @throws QuantityExceededException
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->basket->update($product, $request->input('quantity'));
        return back()->with('updateBasket', 'payment.update product');
    }

    public function checkoutForm()
    {
        return view('checkout');
    }

    public function checkout(Request $request)
    {
        $this->validateForm($request);
        $order = $this->transaction->checkout();
        return redirect(route('home'))->with('successCheckout', __('payment.your order has been registered',
            ['orderNum' => $order->id]));
    }

    protected function validateForm($request)
    {
        $request->validate([
            'method' => 'required',
            'gateway' => 'required_if:method,online'
        ]);
    }

}
