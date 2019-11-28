<?php

use PHPUnit\Framework\TestCase;
use cipher\condicipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class CondiTest extends TestCase
{
    public function testCondi()
    {
        // Test condicipher
        $pt = "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG";
		$ct = "SJP SKBVX WFUKT LRL HCHDQ PJRD NJP WQAY CTX";
        $c = new condicipher(UPPER_ALPHABET, "STRANGE", 25);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding condicipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding condicipher");
                 
    }
}
?>
