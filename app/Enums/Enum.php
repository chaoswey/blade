<?php namespace App\Enums;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;

abstract class Enum implements Arrayable, ArrayAccess, Jsonable, IteratorAggregate, Countable, JsonSerializable
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        if (method_exists($this, 'fill')) {
            $this->items = $this->fill();
        }

        if (!empty($items)) {
            $this->items = $items;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function jsonSerialize()
    {
        return $this->items;
    }

    public function toArray()
    {
        return $this->items;
    }

    public function toJson($options = JSON_NUMERIC_CHECK)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \Exception('Error encoding enum ['.get_class($this).'] to JSON: '.json_last_error_msg());
        }

        return $json;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->items)) {
            $data = $this->items[$name];
            return is_array($data) ? new static($data) : $data;
        }

        throw new \Exception('Property ['.$name.'] does not exist on this enum ['.get_class($this).']');
    }
}