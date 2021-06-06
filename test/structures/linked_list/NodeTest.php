<?php

namespace Structures\linked_list;

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase {

    public function test() {
        $firstNode = new Node('first');
        $secondNode = new Node('second');

        $firstNode->setNext($secondNode);
        $secondNode->setPrev($firstNode);

        $this->assertSame($secondNode, $firstNode->getNext());
        $this->assertSame($firstNode, $secondNode->getPrev());
    }
}
