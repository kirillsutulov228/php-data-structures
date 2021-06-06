<?php


namespace Structures\tree;


class Node {
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var int
     */
    private int $key;

    /**
     * @var Node|null
     */
    private ?Node $left;

    /**
     * @var Node|null
     */
    private ?Node $right;

    /**
     * Node constructor.
     * @param mixed $value
     */
    public function __construct($value, int $key) {
        $this->value = $value;
        $this->key = $key;
        $this->left = null;
        $this->right = null;
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
     * @return int
     */
    public function getKey(): int {
        return $this->key;
    }

    /**
     * @param int $key
     */
    public function setKey(int $key): void {
        $this->key = $key;
    }



    /**
     * @return Node|null
     */
    public function &getLeft(): ?Node {
        return $this->left;
    }

    /**
     * @param Node|null $left
     */
    public function setLeft(?Node $left): void {
        $this->left = $left;
    }

    /**
     * @return Node|null
     */
    public function &getRight(): ?Node {
        return $this->right;
    }

    /**
     * @param Node|null $right
     */
    public function setRight(?Node $right): void {
        $this->right = $right;
    }

}