<?php


namespace linked_list;


class LinkedList {

    /**
     * The first element in the list
     * @var Node|null
     */
    private ?Node $head;

    /**
     * The first element in the list
     * @var Node|null
     */
    private ?Node $tail;

    /**
     * Current size of the list
     * @var int
     */
    private int $size;


    public function __construct() {
        $this->size = 0;
        $this->head = null;
        $this->tail = null;
    }

    /**
     * @param mixed $value storage data
     * @param int|null $index the index to insert the new element (optional)
     * @return bool false if insertion failed, otherwise true
     */
    public function add($value, int $index = null): bool {
        if ($index > $this->size || $index < 0) return false;

        if (!isset($index)) {
            $index = $this->size;
        }

        $addNode = new Node($value);

        if ($index == 0 && !isset($this->head)) {
            $this->head = $addNode;
        }
        else if ($index == 0 && isset($this->head)) {
            $addNode->setNext($this->head);
            $this->head->setPrev($addNode);
            $this->head = $addNode;
        }
        else if ($index == 1 && !isset($this->tail)) {
            $this->tail = $addNode;
            $this->head->setNext($this->tail);
            $this->tail->setPrev($this->head);
        }
        else if ($index == $this->size) {
            $addNode->setPrev($this->tail);
            $this->tail->setNext($addNode);
            $this->tail = $addNode;
        }
        else {
             $currentPos = 0;
             $next = $this->head;
             while ($currentPos < $index) {
                 $next = $next->getNext();
                 $currentPos++;
             }
             $prev = $next->getPrev();
             $addNode->setPrev($prev);
             $addNode->setNext($next);
             $prev->setNext($addNode);
             $next->setPrev($addNode);
        }

        $this->size++;

        return true;

    }

    /**
     * @param int $index the index of the element to retrieve
     * @return false|mixed false if element not exists, otherwise element value
     */
    public function get(int $index) {
        if ($index > $this->size || $index < 0) return false;
        $currentNode = $this->head;
        $currentPos = 0;
        while ($currentPos < $index) {
            $currentNode = $currentNode->getNext();
            $currentPos++;
        }
        return $currentNode->getValue();
    }

    /**
     * @return mixed|null
     */
    public function getLast() {
        if (!isset($this->tail)) {
            return null;
        }
        return $this->tail->getValue();
    }

    /**
     * @return mixed|null
     */
    public function getFirst() {
        if (!isset($this->head)) {
            return null;
        }
        return $this->head->getValue();
    }

    /**
     * @return array - values of the linked list in default array
     */
    public function values(): array {
        $currentNode = $this->head;
        $values = [];
        while (isset($currentNode)) {
            $values[] = $currentNode->getValue();
            $currentNode = $currentNode->getNext();
        }
        return $values;
    }

    /**
     * @return int
     */
    public function getSize(): int {
        return $this->size;
    }


}