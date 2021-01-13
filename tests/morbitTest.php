<?php

use PHPUnit\Framework\TestCase;
use cipher\morbitcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class MorbitTest extends TestCase
{
    public function testMorbit ()
    {
        // Test Morbit
        $pt = "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG";
        $ct = "8443791313255617543569396231298517193168153479841335784437143894618646965";
        $c = new morbitcipher(UPPER_ALPHABET, "KABOUTERS");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding morbitcipher");
        $res = strtoupper($c->decode ($ct));
        $this->assertEquals($pt,$res, "Error decoding morbitcipher");               
    }
}

?>
