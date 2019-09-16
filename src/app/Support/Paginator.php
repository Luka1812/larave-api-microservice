<?php

namespace App\Support;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Countable;
use IteratorAggregate;
use ArrayIterator;

class Paginator implements Countable, IteratorAggregate
{
    /**
     * All of the items being paginated.
     *
     * @var \Doctrine\Common\Collections\Collection|array
     */
    private $items;

    /**
     * The start index of paginator.
     *
     * @var int
     */
    private $startIndex;

    /**
     * The number of items in current paginator.
     * @var int
     */
    private $numberOfItems;

    /**
     * The total number of items in paginator.
     *
     * @var int
     */
    private $totalNumberOfItems;

    /**
     * Paginator constructor.
     *
     * @param  \Doctrine\Common\Collections\Collection|array  $items
     * @param  int  $startIndex
     * @param  int  $totalNumberOfItems
     *
     * @return void
     */
    public function __construct($items, int $startIndex, int $totalNumberOfItems)
    {
        $this->startIndex = $startIndex;
        $this->totalNumberOfItems = $totalNumberOfItems;

        $this->setItems($items);
        $this->setNumberOfItems();
    }

    /**
     * Set the items for the paginator.
     *
     * @param  \Doctrine\Common\Collections\Collection|array  $items
     *
     * @return void
     */
    private function setItems($items) : void
    {
        if ($items instanceof Collection) {
            $this->items = $items;
        } else {
            $this->items = new ArrayCollection($items);
        }
    }

    /**
     * Set the number of items from items collection.
     *
     * @return void
     */
    private function setNumberOfItems()
    {
        $this->numberOfItems = $this->items->count();
    }

    /**
     * Get start index from the paginator.
     *
     * @return int
     */
    public function getStartIndex() : int
    {
        return $this->startIndex;
    }

    /**
     * Get number of items from the paginator.
     *
     * @return int
     */
    public function getNumberOfItems() : int
    {
        return $this->count();
    }

    /**
     * Get total number of items from the paginator.
     *
     * @return int
     */
    public function getTotalNumberOfItems() : int
    {
        return $this->totalNumberOfItems;
    }

    /**
     * Get paginator items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems() : Collection
    {
        return $this->items;
    }

    /**
     * Get items count from paginator.
     *
     * @return int
     */
    public function count() : int
    {
        return $this->numberOfItems;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items->toArray());
    }
}
