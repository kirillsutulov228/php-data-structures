<?php

namespace Structures\hash_table;

use PHPUnit\Framework\TestCase;
use stdClass;

class HashTableTest extends TestCase {

    public function testAddAndGet() {
        $hashTable = new HashTable();
        for ($i = 0; $i < 10; ++$i) {
            $hashTable->put($i, $i);
        }
        $this->assertSame(5, $hashTable->get(5));
        $this->assertTrue($hashTable->hasKey(5));
        $this->assertTrue($hashTable->hasValue(5));

        $this->assertFalse($hashTable->hasKey(10));
        $this->assertFalse($hashTable->hasValue(10));

        $hashTable->put('new value', 5);
        $this->assertSame('new value', $hashTable->get(5));

        $object = new stdClass();
        $object->value = 5;

        $hashTable->put($object, 'key');
        $this->assertSame($object, $hashTable->get('key'));

        $hashTable->put( 'value', $object);
        $this->assertSame('value', $hashTable->get($object));

    }

}
