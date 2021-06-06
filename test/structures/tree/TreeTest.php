<?php

namespace Structures\tree;

use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase {

    public function testAddAndGet() {
        $tree = new Tree([0 => 'root', -5 => 'left', 5 => 'right', 15 => 'right-right']);
        $this->assertSame(['left', 'root', 'right','right-right'], $tree->values());

        $tree->add('right-left', 8);
        $this->assertTrue($tree->find(8));

        $tree->update('right-left updated', 8);
        $this->assertSame('right-left updated', $tree->get(8));

        $this->assertFalse($tree->update('not exists', 10));
    }

    public function testRemoveAndFind() {
        $tree = new Tree([0 => 'root', -5 => 'left', 5 => 'right', 15 => 'right-right']);
        $tree->remove(0);
        $this->assertFalse($tree->find(0));
        $tree->remove(5);
        $this->assertFalse($tree->find(5));

        $this->assertFalse($tree->remove(10));
        $this->assertTrue($tree->remove(15));

        $this->assertSame(1,$tree->size());

        $this->assertTrue($tree->remove(-5));
        $this->assertSame(0,$tree->size());

    }
}
