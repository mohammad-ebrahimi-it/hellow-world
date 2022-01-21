<?php

namespace App\Support\Payment\Gateways;

use App\Models\Order;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class Saman implements GatewayInterface
{

    private $merchantID;
    private $callback;

    public function __construct()
    {
        $this->merchantID = '452585658';
        $this->callback = route('payment.verify', $this->getName());
    }


    public function pay(Order $order)
    {
        $this->redirectToBank($order);
    }

    private function redirectToBank($order) {
        $amount = $order->amount + 10000;
        echo "
        <form id='samanpayment' action='https://sep.shaparak.ir/payment.aspx' method='post'>
            <input type='hidden' name='Amount' value='{$amount}'>
            <input type='hidden' name='ResName' value='{$order->code}'>
            <input type='hidden' name='RedirectURL' value='{$order->callback}'>
            <input type='hidden' name='MID' value='{$order->merchantID}'>
            <input type='hidden' name='Amount' value='{$order->amount}'>
        </form><script>document.forms['samanpayment'].submit()</script>
        ";
    }

    public function verify(Request $request)
    {
        // TODO: Implement verify() method.
    }

    public function getName(): string
    {
        return 'saman';
    }
}
