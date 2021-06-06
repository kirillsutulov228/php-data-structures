<?php

namespace linked_list;

use PHPUnit\Framework\TestCase;

class LinkedListTest extends TestCase {

    public function testAddAndGet() {
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

    public function testConstructor() {
        $list = new LinkedList([1, 2, 3, 4, 5]);
        $this->assertSame([1,2,3,4,5], $list->values());

        $list->addFromArray([6,7,8,9]);
        $this->assertSame([1,2,3,4,5,6,7,8,9], $list->values());

    }

    public function testFind() {
        $list = new LinkedList([18, 'apple', -56, 0, '15']);
        $this->assertTrue($list->find(0));
        $this->assertTrue($list->find('apple'));
        $this->assertFalse($list->find('fish'));
    }

    public function testRemove() {
        $list = new LinkedList([18, 'apple', -56, 0, '15']);

        $this->assertTrue($list->removeByIndex(2));
        $this->assertSame([18, 'apple', 0, '15'], $list->values());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame(['apple', 0, '15'], $list->values());

        $this->assertTrue($list->removeByIndex(2));
        $this->assertSame(['apple', 0], $list->values());

        $this->assertTrue($list->removeByIndex(1));
        $this->assertSame(['apple'], $list->values());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame([], $list->values());

        $list->addFromArray(['first', 'second']);

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame('second', $list->getLast());
        $this->assertSame('second', $list->getFirst());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame([], $list->values());

        $this->assertSame(0, $list->getSize());

        $list->addFromArray([1,2,3,4,5]);

        $this->assertTrue($list->removeByIndex($list->getSize() - 1));
        $this->assertSame([1,2,3,4], $list->values());

        $this->assertTrue($list->removeByIndex($list->getSize() - 1));
        $this->assertSame([1,2,3], $list->values());

        $this->assertTrue($list->removeByIndex($list->getSize() - 1));
        $this->assertSame([1,2], $list->values());

        $this->assertTrue($list->removeByIndex($list->getSize() - 1));
        $this->assertSame([1], $list->values());

        $this->assertTrue($list->removeByIndex($list->getSize() - 1));
        $this->assertSame([], $list->values());

        $list->addFromArray([5, 4, 3, 2, 1]);

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame([4,3,2,1], $list->values());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame([3,2,1], $list->values());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame([2,1], $list->values());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertFalse($list->removeByIndex(1));
        $this->assertSame([1], $list->values());

        $this->assertTrue($list->removeByIndex(0));
        $this->assertSame([], $list->values());

    }

}
