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


    /**
     * LinkedList constructor.
     * @param array|null $values array of the initial values (optional)
     */
    public function __construct(array $values = null) {
        $this->size = 0;
        $this->head = null;
        $this->tail = null;
        if (isset($values)) {
            $this->addFromArray($values);
        }
    }

    public function addFromArray(array $values) {
            foreach ($values as $value) {
                $this->add($value);
            }
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
     * @return mixed|null last element value if exists, null otherwise
     */
    public function getLast() {
        if ($this->size == 0) {
            return null;
        }
        else if ($this->size == 1) {
            return $this->head->getValue();
        }
        return $this->tail->getValue();
    }

    /**
     * @return mixed|null first element value if exists, null otherwise
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
     * @param mixed $value the value to be found in the list
     * @return bool true if list contains the value, otherwise false
     */
    public function find($value): bool {
        $currentNode = $this->head;
        while (isset($currentNode)) {
            if ($currentNode->getValue() === $value) {
                return true;
            }
            $currentNode = $currentNode->getNext();
        }
        return false;
    }

    /**
     * @param int $index the index of the element to remove
     * @return bool true if the element successfully removed, false otherwise
     */
    public function removeByIndex(int $index): bool {
        if ($index >= $this->size || $index < 0) return false;

        if ($index == 0) {
            if ($this->size == 1) {
                $this->head = null;
                $this->tail = null;
            }
            else if ($this->size == 2) {
               $this->head = $this->tail;
               $this->tail = null;
               $this->head->setNext(null);
               $this->head->setPrev(null);
            }
            else {
                $this->head = $this->head->getNext();
                $this->head->setPrev(null);
            }
        }

        else if ($index == $this->size - 1) {
            if ($this->size == 1) {
                $this->tail = null;
                $this->head = null;
            }
            else if ($this->size == 2) {
                $this->tail = null;
                $this->head->setNext(null);
            }
            else {
                $this->tail=$this->tail->getPrev();
                $this->tail->setNext(null);
            }
        }

        else {
            $removeNode = $this->head;
            $currentPos = 0;
            while ($currentPos < $index) {
                $removeNode = $removeNode->getNext();
                $currentPos++;
            }
            $prev = $removeNode->getPrev();
            $next = $removeNode->getNext();
            $prev->setNext($next);
            $next->setPrev($prev);
        }
        $this->size--;
        return true;
    }

    /**
     * @return int current size of the list
     */
    public function getSize(): int {
        return $this->size;
    }

}