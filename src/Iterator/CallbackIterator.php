<?php

namespace PhpStdlib\Iterator;


use IteratorIterator;
use Traversable;

/**
 * An iterator that applies a callback to each item
 * before returning it.
 */
class CallbackIterator extends IteratorIterator
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * $callback should be a valid callback that accepts the following arguments:
     * - $current: the current item
     * - iterator: the iterator object
     *
     * @param Traversable $iterator
     * @param callable $callback
     */
    public function __construct(Traversable $iterator, callable $callback)
    {
        parent::__construct($iterator);

        if (is_null($callback)) {
            throw new \InvalidArgumentException("Null callback");
        }

        $this->callback = $callback;
    }

    public function current()
    {
        return call_user_func($this->callback, parent::current(), $this->getInnerIterator());
    }
}