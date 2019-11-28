<?php

use PHPUnit\Framework\TestCase;
use cipher\polyalphabeticcipher\vigenerecipher\nicodemuscipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class NicodemusTest extends TestCase
{
    public function testNicodemus()
    {
	
        // Test caesar
        $pt = "THEEARLYBIRDGETSTHEWORM";
        $ct = "HAYREVGNKIXKUWMTWMUGTAH";
        $c = new nicodemuscipher(UPPER_ALPHABET, "CAT");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding nicodemuscipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding nicodemuscipher");
                 
    }
}
?>
