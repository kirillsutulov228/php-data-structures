<?php


namespace Structures\tree;


class Tree {

    private ?Node $root;
    private int $size;

    /**
     * Tree constructor.
     * @param array $arr (optional) array that used for filling the tree. Keys must be an integers
     */
    public function __construct(array $arr) {
        $this->root = null;
        $this->size = 0;
        if (isset($arr)) {
            $this->addFromArray($arr);
        }
    }

    /**
     * @return int current size of the tree
     */
    public function size(): int {
        return $this->size;
    }

    /**
     * @param array $arr array that used for filling the tree. Keys must be an integers
     * @param bool $updateMode if true, existing elements will be updated
     * @return bool true if elements added successfully, false otherwise
     */
    public function addFromArray(array $arr, bool $updateMode = false): bool {
        foreach ($arr as $key => $value) {
            if (!is_int($key)) {
                return false;
            }
        }
        foreach ($arr as $key => $value) {
            $this->add($value, $key, $updateMode);
        }
        return true;
    }

    /**
     * @param mixed $value value to insert
     * @param int $key key for the inserted element
     * @param bool $updateMode if true, existing element with equal key
     * will be updated. If element not exists, it will be created.
     * @return bool true if element added or updated, otherwise false
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
        $currentNode = $addNode;
        $this->size++;
        return true;
    }

    /**
     * @param mixed $value value to update
     * @param int $key key for the updates element
     * @return bool true if element exists and updated, otherwise false
     */
    public function update($value, int $key): bool {
        $currentNode = $this->root;
        while (isset($currentNode)) {
            if ($key < $currentNode->getKey()) {
                $currentNode = $currentNode->getLeft();
            } else if ($key > $currentNode->getKey()) {
                $currentNode = $currentNode->getRight();
            } else if ($key == $currentNode->getKey()) {
                $currentNode->setValue($value);
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $key the key to find the element
     * @return mixed|null if element found, returns its value, null otherwise
     */
    public function get(int $key) {
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
     * @return array indexed array of tree values
     */
    public function values(): array {
        return $this->recursiveValues($this->root);
    }

    /**
     * @return Node|null root of the tree
     */
    public function getRoot(): ?Node {
        return $this->root;
    }

    /**
     * @param int $key the key of the element to remove
     * @return bool true if element exists and successfully removed, otherwise false
     */
    public function remove(int $key): bool {
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
     * @param Node|null $node node for the insertion
     * @param bool $recursive if true, node every child will be added recursively
     * @param bool $updateMode if true, existing element with equal key
     * will be updated. If element not exists, it will be created.
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
     * @return int the number of elements with an parent node (include parent)
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
     * @return array indexed array of values from parent node
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