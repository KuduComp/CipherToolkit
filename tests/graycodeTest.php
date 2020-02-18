<?php

use PHPUnit\Framework\TestCase;
use cipher\graycode;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class GraycodeTest extends TestCase
{
    public function testGraycode ()
    {
        // Test goldbugcipher
		$c = new graycode (8);

		$pt = "1 2 3 4 5 6 100 101 101 333 666 999";
		$ct = "00000001 00000011 00000010 00000110 00000111 00000101 01010110 01010111 01010111 111101011 1111010111 1000010100";

        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding graycode");

        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding graycode");

    }
}
 
?>
