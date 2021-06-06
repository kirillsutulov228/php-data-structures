<?php


namespace Structures\tree;


use phpDocumentor\Reflection\Types\Mixed_;

class Tree {

    private ?Node $root;
    private int $size;

    /**
     * Tree constructor.
     * @param array $arr
     */
    public function __construct(array $arr) {
        $this->root = null;
        $this->size = 0;
        if (isset($arr)) {
            $this->addFromArray($arr);
        }
    }

    /**
     * @return int
     */
    public function size(): int {
        return $this->size;
    }

    /**
     * @param array $arr
     * @param bool $updateMode
     * @return bool
     */
    public function addFromArray(array $arr, bool $updateMode = false): bool {
        foreach ($arr as $key => $value) {
            if (!is_int($key)) {
                return false;
            }
            $this->add($value, $key, $updateMode);
        }
        return true;
    }

    /**
     * @param $value
     * @param int $key
     * @param bool $updateMode
     * @return bool
     */
    public function add($value, int $key, bool $updateMode = false): bool {
        $addNode = new Node($value, $key);
        if (!isset($this->root)) {
            $this->root = $addNode;
        }
        else {
            $currentNode = &$this->root;
            while (isset($currentNode)) {
                if ($key < $currentNode->getKey()) {
                    $currentNode = &$currentNode->getLeft();
                } else if ($key > $currentNode->getKey()) {
                    $currentNode = &$currentNode->getRight();
                } else if ($key == $currentNode->getKey()) {
                    if ($updateMode) {
                        $currentNode->setValue($value);
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
        }
        if (!$updateMode) {
            $currentNode = $addNode;
            $this->size++;
            return true;
        }
        return false;
    }

    /**
     * @param $value
     * @param $key
     * @return bool
     */
    public function update($value, $key): bool {
        return $this->add($value, $key, true);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key) {
        $currentNode = $this->root;
        while (isset($currentNode)) {
            if ($currentNode->getKey() == $key) {
                return $currentNode->getValue();
            }
            else if ($key < $currentNode->getKey()) {
                $currentNode = $currentNode->getLeft();
            }
            else if ($key > $currentNode->getKey()) {
                $currentNode = $currentNode->getRight();
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public function values(): array {
        return $this->recursiveValues($this->root);
    }

    /**
     * @return Node|null
     */
    public function getRoot(): ?Node {
        return $this->root;
    }

    /**
     * @param $key
     * @return bool
     */
    public function remove($key): bool {
        $currentNode = &$this->root;
        while (isset($currentNode)) {
            if ($currentNode->getKey() == $key) {
                $left = $currentNode->getLeft();
                $right = $currentNode->getRight();
                $currentNode = null;
                $this->addNode($left);
                $this->addNode($right);
                $this->size = $this->recursiveSize();
                return true;
            }
            else if ($key < $currentNode->getKey()) {
                $currentNode = &$currentNode->getLeft();
            }
            else if ($key > $currentNode->getKey()) {
                $currentNode = &$currentNode->getRight();
            }
        }
        return false;
    }

    public function find(int $key): bool {
        $val = $this->get($key);
        return isset($val);
    }

    /**
     * @param Node|null $node
     * @param bool $recursive
     * @param bool $updateMode
     */
    public function addNode(?Node $node, bool $recursive = false, bool $updateMode = false) {
        if (!isset($this->root)) {
            $this->root = $node;
            return;
        }
        if ($node == null) {
            return;
        }
        if ($recursive) {
            $this->add($node->getValue(), $node->getKey(), $updateMode);
            $this->recursiveAdd($node->getLeft(), true, $updateMode);
            $this->recursiveAdd($node->getRight(), true, $updateMode);
        }
        else {
            $currentNode = &$this->root;
            $key = $node->getKey();
            while (isset($currentNode)) {
                if ($currentNode->getKey() == $key) {
                    break;
                } else if ($key < $currentNode->getKey()) {
                    $currentNode = &$currentNode->getLeft();
                } else if ($key > $currentNode->getKey()) {
                    $currentNode = &$currentNode->getRight();
                }
            }
            $currentNode = $node;
        }
    }

    /**
     * @param Node|null $node
     * @param bool $firstCall
     * @return int
     */
    private function recursiveSize(?Node $node = null, bool $firstCall = true): int {
        static $size;
        if ($firstCall) {
            $size = 0;
            if (!isset($node)) {
                $node = $this->root;
            }
        }
        if (!isset($node)) {
            return 0;
        }

        $size++;
        $this->recursiveSize($node->getLeft(), false);
        $this->recursiveSize($node->getRight(), false);

        return $size;
    }

    /**
     * @param Node|null $node
     * @param bool $firstCall
     * @return array
     */
    private function recursiveValues(?Node $node, bool $firstCall = true): array {
        static $values;
        if ($firstCall) {
            $values = [];
        }
        if (!isset($node)) {
            return [];
        }
        $this->recursiveValues($node->getLeft(), false);
        $values[] = $node->getValue();
        $this->recursiveValues($node->getRight(), false);
        return $values;
    }

}