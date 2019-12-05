<?php

use PHPUnit\Framework\TestCase;
use cipher\fractionatedmorsecipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class FractionatedMorseTest extends TestCase
{
    public function testFractionatedMorse ()
    {
        // Test Vatsyayana
        $pt = "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG";
        $ct = "JRSWTOPVFCZRQBIDVYNWKOYHPKJGPLHPTAFXRAYEQWUCMEWKF";
        $c = new fractionatedmorsecipher(UPPER_ALPHABET, "ROUNDTABLE");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding fractionatedmorsecipher");
        $res = strtoupper($c->decode ($ct));
        $this->assertEquals($pt,$res, "Error decoding fractionatedmorsecipher");               
    }
}

?>
