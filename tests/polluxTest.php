<?php

use PHPUnit\Framework\TestCase;
use cipher\polluxcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class PolluxTest extends TestCase
{
    public function testPollux ()
    {
        // Test polluxcipher
        $pt = "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG";
        $ct = "8443791313255617543569396231298517193168153479841335784437143894618646965";
        $c = new polluxcipher(UPPER_ALPHABET, "3460", "278", "159");
        $res = $c->encode ($pt);
		//The generated ciphertext is random and cannot be asserted
        //$this->assertEquals($ct,$res, "Error encoding polluxcipher");
        $res = strtoupper($c->decode ($res));
        $this->assertEquals($pt,$res, "Error en/decoding polluxcipher");               
    }
}

?>
