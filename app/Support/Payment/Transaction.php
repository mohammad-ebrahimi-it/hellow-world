<?php

namespace App\Support\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Support\Basket\Basket;
use App\Support\Payment\Gateways\Pasargad;
use App\Support\Payment\Gateways\Saman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Transaction
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Basket
     */
    protected $basket;

    /**
     * @param Request $request
     * @param Basket $basket
     */
    public function __construct(Request $request, Basket $basket)
    {
        $this->request = $request;
        $this->basket = $basket;
    }

    public function checkout()
    {
        $order = $this->makeOrder();
       $payment =  $this->makePayments($order);
        if ($payment->isOnline())
            dd($this->gatewayFactory()->pay($order));
        $this->basket->clear();
        return $order;
    }

    public function makeOrder()
    {
        $order = Order::create([
            Order::USER_ID => Auth::id(),
            Order::CODE => bin2hex(Str::random('16')),
            Order::AMOUNT => $this->basket->subTotal()
        ]);

        $order->products()->attach($this->products());
        return $order;
    }


    private function products(): array
    {
        foreach ($this->basket->all() as $item) {
            $products[$item->id] = ['quantity' => $item->quantity];
        }

        /** @noinspection PhpUndefinedVariableInspection */
        return $products;
    }


    protected function makePayments($order)
    {
        return Payment::create([
            Payment::ORDER_ID => $order->id,
            Payment::METHOD => $this->request->input(Payment::METHOD),
            Payment::AMOUNT => $order->amount
        ]);
    }

    private function gatewayFactory()
    {
        $gateway = [
            'saman' => Saman::class,
            'pasargad' => Pasargad::class
        ][$this->request->input(Payment::GATEWAY)];

        return resolve($gateway);
    }


}
