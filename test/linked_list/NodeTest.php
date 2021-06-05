<?php

namespace linked_list;

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase {

    public function test() {
        $firstNode = new Node('first');
        $secondNode = new Node('second');

        $firstNode->setNext($secondNode);
        $secondNode->setPrev($firstNode);

        $this->assertSame($firstNode->getNext(), $secondNode);
        $this->assertSame($secondNode->getPrev(), $firstNode);
    }
}
