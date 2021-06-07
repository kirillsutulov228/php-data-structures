<?php


namespace Structures\hash_table;


use Exception;


class Hasher {

    /**
     * @var array object container
     */
    private array $objects = [];

    /**
     * @var Hasher the instance
     */
    private static Hasher $hasher;

    private function __construct() {}

    /**
     * Get singleton instance
     * @return Hasher
     */
    public static function getInstance(): Hasher {
        if (!isset(self::$hasher)) {
            self::$hasher = new Hasher();
        }
        return self::$hasher;
    }

    /**
     * object compatible equivalent of the 'in_array()' function
     * @param $needle
     * @param array $haystack
     * @return bool
     */
    private function objectInArray($needle, array $haystack): bool {
        $type = gettype($needle);
        if ($type !== 'object') {
            return in_array($needle, $haystack, true);
        }
        else {
            foreach ($haystack as $value) {
                if (gettype($value) === 'object' && $needle == $value) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * object compatible equivalent of the 'array_search()' function
     * @param $needle
     * @param $haystack
     * @return false|int|string
     */
    private function objectSearchInArray($needle, $haystack) {
        $type = gettype($needle);
        if ($type !== 'object') {
            return array_search($needle, $haystack, true);
        }
        else {
            foreach ($haystack as $key => $value) {
                if (gettype($value) === 'object' && $needle == $value) {
                    return $key;
                }
            }
        }
        return false;
    }

    /**
     * This function generates hash code for primitive and reference types.
     * If you object has method 'hashCode()', it will be used instead of the default implementation
     * @param $variable
     * @return int hash code of the object
     */
    public function hashCode($variable): int {
        if (gettype($variable) === 'object' && method_exists($variable, 'hashCode')) {
            $hash = $variable->hashCode();
            $this->objects[$hash] = $variable;
            return $hash;
        }

        if (!$this->objectInArray($variable, $this->objects)) {
            $hash = 0;
            try {
                $hash = random_int(-2147483648, 2147483647);
            } catch (Exception $e) {
                echo $e->getTraceAsString();
            }
            $this->objects[$hash] = $variable;
            return $hash;
        }
        return $this->objectSearchInArray($variable, $this->objects);
    }
}