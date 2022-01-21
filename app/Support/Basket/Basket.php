<?php

namespace App\Support\Basket;

use App\Exceptions\QuantityExceededException;
use App\Models\Product;
use App\Support\Storage\Contracts\StorageInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Basket
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @throws QuantityExceededException
     */
    public function add(Product $product, $quantity)
    {
        if ($this->has($product)) {
            $quantity = $this->get($product)['quantity'] + $quantity;
        }
        $this->update($product, $quantity);

    }

    /**
     * @throws QuantityExceededException
     */
    public function update(Product $product,int $quantity)
    {

        if (!$product->hasStock($quantity)){
            throw new QuantityExceededException();
        }
        $this->storage->set($product->id, [
            'quantity' => $quantity
        ]);
        if (!$quantity){

            $this->storage->unset($product->id);
        }

    }

    public function get(Product $product)
    {
        return $this->storage->get($product->id);
    }

    public function has(Product $product)
    {
        return $this->storage->exists($product->id);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function itemCount(): int
    {
        return $this->storage->count();
    }

    public function all()
    {
        $products = Product::find(array_keys($this->storage->all()));
        foreach ($products as $product) {
            $product->quantity = $this->get($product)['quantity'];
        }
        return $products;
    }

    public function subTotal()
    {
        $total = 0;
        foreach ($this->all() as $item){
            $total += $item->price * $item->quantity;
        }
        return $total;
    }

    public function clear()
    {
        return $this->storage->clear();
    }
}
