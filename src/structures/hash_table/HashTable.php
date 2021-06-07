<?php


namespace Structures\hash_table;


use phpDocumentor\Reflection\Types\Boolean;

class HashTable {

    private Hasher $hasher;
    private int $tableSize;

    /**
     * @var array array of node lists
     */
    private array $table;

    public function __construct(int $tableSize = 10) {
        $this->hasher = Hasher::getInstance();
        $this->tableSize = $tableSize;
        $this->table = [];
        for ($i = 0; $i < $tableSize; ++$i) {
            $this->table[$i] = [];
        }
    }

    /**
     * Calculates the index of the node list based on parameter hashcode
     * @param $variable
     * @return int index
     */
    private function getIndex($variable): int {
        $hash = $this->hasher->hashCode($variable);
        return abs($hash) % $this->tableSize;
    }

    /**
     * @param $key
     * @return Node|null node with the key from table
     */
    private function getNode($key): ?Node {
        $index = $this->getIndex($key);
        $list = $this->table[$index];
        foreach ($list as $node) {
            if ($node->getkey() == $key) {
                return $node;
            }
        }
        return null;
    }

    /**
     * Add the new node to the hash table. If key exists, the value will be updated
     * @param $value
     * @param $key
     */
    public function put($value, $key) {
        $hash = $this->hasher->hashCode($key);
        $index = $this->getIndex($key);
        $node = $this->getNode($key);
        if (isset($node)) {
            $node->setValue($value);
        }
        else {
            $this->table[$index][] = new Node($hash, $key, $value);
        }
    }

    /**
     * @param $key
     * @return mixed|null the value with the given key
     */
    public function get($key) {
        $node = $this->getNode($key);
        if (isset($node)) {
            return $node->getValue();
        }
        return null;
    }

    /**
     * Remove the element from the hash table
     * @param $key
     * @return bool true if the element was removed, otherwise false
     */
    public function remove($key): bool {
        $index = $this->getIndex($key);
        $list = $this->table[$index];
        foreach ($list as $node) {
            if ($node->getkey() == $key) {
                unset($node);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $key
     * @return bool true if key is found in hash table, false otherwise
     */
    public function hasKey($key): bool {
        return $this->get($key) !== null;
    }

    /**
     * @param $value
     * @return bool true if value is found in hash table, false otherwise
     */
    public function hasValue($value): bool {
        foreach ($this->table as $list) {
            if (!empty($list)) {
                foreach ($list as $node) {
                    if (gettype($value) === 'object' && $node->getValue() == $value ||
                        gettype($value) !== 'object' && $node->getValue() === $value) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}