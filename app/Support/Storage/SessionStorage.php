<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace App\Support\Storage;

use App\Support\Storage\Contracts\StorageInterface;
use Countable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SessionStorage implements StorageInterface, Countable
{

    /**
     * @var string
     */
    private $bucket;

    /**
     * @param string $bucket
     */
    public function __construct(string $bucket = 'default')
    {
        $this->bucket = $bucket;
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get($index)
    {
        return session()->get($this->bucket . '.' . $index);
    }

    public function set($index, $value)
    {
        return session()->put($this->bucket . '.'.$index, $value);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function all()
    {
        return session()->get($this->bucket) ?? [];
    }

    public function exists($index): bool
    {
        return session()->has($this->bucket . '.' . $index);
    }

    public function unset($index)
    {
        return session()->forget($this->bucket . '.' . $index);
    }

    public function clear()
    {
        return session()->forget($this->bucket);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function count(): int
    {
        return count($this->all());
    }
}
