<?php

namespace Structures\hash_table;

use PHPUnit\Framework\TestCase;
use stdClass;

class HasherTest extends TestCase {

    public function testHashPrimitives() {
        $hasher = Hasher::getInstance();
        $this->assertSame($hasher, Hasher::getInstance());
        $integer = 15;
        $string = 'str';
        $boolean = true;

        $integerHash = $hasher->hashCode($integer);
        $stringHash = $hasher->hashCode($string);
        $booleanHash = $hasher->hashCode($boolean);

        $this->assertSame($integerHash, $hasher->hashCode(15));
        $this->assertSame($stringHash, $hasher->hashCode('str'));
        $this->assertSame($booleanHash, $hasher->hashCode(true));
    }

    public function testObjectHast() {

        $hasher = Hasher::getInstance();

        $object1 = new stdClass();
        $object1->field = 'someField';
        $object2 = $object1;

        $hash1 = $hasher->hashCode($object1);
        $hash2 = $hasher->hashCode($object2);
        $this->assertSame($hash1, $hash2);

        $object2 = new stdClass();
        $object2->field = 'someField';


        $hash1 = $hasher->hashCode($object1);
        $hash2 = $hasher->hashCode($object2);
        $this->assertSame($hash1, $hash2);

        $object2->field = 'differentField';

        $hash1 = $hasher->hashCode($object1);
        $hash2 = $hasher->hashCode($object2);
        $this->assertNotSame($hash1, $hash2);

        unset($object2->field);
        unset($object1->field);

        $hash1 = $hasher->hashCode($object1);
        $hash2 = $hasher->hashCode($object2);
        $this->assertSame($hash1, $hash2);

        $object1->someField = 'value';
        $object2->anotherField = 'value';


        $hash1 = $hasher->hashCode($object1);
        $hash2 = $hasher->hashCode($object2);
        $this->assertNotSame($hash1, $hash2);
    }
}
