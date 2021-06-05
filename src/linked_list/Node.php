<?php


namespace linked_list;


class Node {

    /**
     * data to store in the Node
     * @var mixed
     */
    private $value;

    /**
     * Reference to the previous element
     * @var Node|null
     */
    private ?Node $prev;

    /**
     * Reference to the next element
     * @var Node|null
     */
    private ?Node $next;


    /**
     * Node constructor.
     * @param $value
     */
    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void {
        $this->value = $value;
    }

    /**
     * @return Node|null
     */
    public function getPrev(): ?Node {
        return $this->prev;
    }

    /**
     * @param Node|null $prev
     */
    public function setPrev(?Node $prev): void {
        $this->prev = $prev;
    }

    /**
     * @return Node|null
     */
    public function getNext(): ?Node {
        return $this->next;
    }

    /**
     * @param Node|null $next
     */
    public function setNext(?Node $next): void {
        $this->next = $next;
    }

}