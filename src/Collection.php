<?php

namespace Vanchelo\ExternalUrls;

use ArrayAccess;
use ArrayIterator;
use CachingIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * The items contained in the collection
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Create a new collection instance if the value isn't one already
     *
     * @param mixed $items
     *
     * @return static
     */
    public static function make($items)
    {
        if (is_null($items)) {
            return new static;
        }

        if ($items instanceof Collection) {
            return $items;
        }

        return new static(is_array($items) ? $items : [$items]);
    }

    /**
     * Get all of the items in the collection
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Return only unique items from the collection array
     *
     * @return static
     */
    public function unique()
    {
        return new static(array_unique($this->items));
    }

    /**
     * Reset the keys on the underlying array
     *
     * @return static
     */
    public function values()
    {
        $this->items = array_values($this->items);

        return $this;
    }

    /**
     * Get the collection of items as a plain array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Get an iterator for the items
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get a CachingIterator instance
     *
     * @param  int $flags
     *
     * @return \CachingIterator
     */
    public function getCachingIterator($flags = CachingIterator::CALL_TOSTRING)
    {
        return new CachingIterator($this->getIterator(), $flags);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
