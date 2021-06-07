<?php


namespace Structures\hash_table;


class Node {

    private int $hash;
    private $key;
    private $value;

    /**
     * Node constructor.
     * @param int $hash
     * @param $key
     * @param $value
     */
    public function __construct(int $hash, $key, $value) {
        $this->hash = $hash;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getHash(): int {
        return $this->hash;
    }

    /**
     * @param int $hash
     */
    public function setHash(int $hash): void {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void {
        $this->key = $key;
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



}