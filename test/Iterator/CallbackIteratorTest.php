<?php

namespace PhpStdlib\Test\Iterator;


use PhpStdlib\Iterator\CallbackIterator;
use Traversable;

class CallbackIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayIterator()
    {
        $arrayIterator = new \ArrayIterator([1,2,3,4,5,6,7,8,9,10]);

        $callbackIterator = new CallbackIterator($arrayIterator, function ($current) {
            return ++$current;
        });

        $i = 2;
        foreach ($callbackIterator as $n) {
            $this->assertEquals($i++, $n);
        }
    }

    public function testCallbackGenerator()
    {
        $callbackIterator = new CallbackIterator(new MockGenerator(), [$this, 'add1']);

        $i = 2;
        foreach ($callbackIterator as $n) {
            $this->assertEquals($i++, $n);
        }
    }

    public function add1($current, $iterator)
    {
        return ++$current;
    }

}

class MockGenerator implements \IteratorAggregate
{
    protected $start;
    protected $end;
    protected $index;

    public function __construct($start=1, $end=10)
    {
        $this->start = $start;
        $this->end = $end;
        $this->index = 0;
    }

    public function getIterator()
    {
        if (($this->start + $this->index) > $this->end) {
            return;
        }

        yield $this->start + ($this->index++);
    }
}