<?php

namespace linked_list;

use PHPUnit\Framework\TestCase;

class LinkedListTest extends TestCase {

    public function addAndGetTest() {
        $list = new LinkedList();

        $this->assertFalse($list->add('invalid', -1));

        $this->assertTrue($list->add('first'));
        $this->assertSame( 'first', $list->get(0));
        $this->assertSame(1, $list->getSize());

        $this->assertTrue($list->add('second'));
        $this->assertSame( 'second', $list->get(1));

        $this->assertTrue($list->add('between', 1));
        $this->assertSame('between', $list->get(1));

        $this->assertTrue($list->add('left_between', 1));
        $this->assertSame('left_between', $list->get(1));

        $this->assertTrue($list->add('new_head', 0));
        $this->assertSame( 'new_head', $list->getFirst());

        $this->assertSame('second', $list->getLast());

        $this->assertSame(['new_head', 'first', 'left_between', 'between', 'second'], $list->values());

        $this->assertTrue($list->add('new_tail', 5));
        $this->assertTrue($list->add('new_tail', 6));
        $this->assertSame(['new_head', 'first', 'left_between', 'between', 'second', 'new_tail', 'new_tail'], $list->values());
    }

}
