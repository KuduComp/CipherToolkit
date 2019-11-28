<?php

use PHPUnit\Framework\TestCase;
use cipher\columnartranspositioncipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)
class ColumnarTranspositionTest extends TestCase
{
    public function testColumnarTransposition()
    {
        
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "HCWJOHYTIOXSTZUROPRAGQBFMELOEKNUVED";
        $c = new columnartranspositioncipher(UPPER_ALPHABET, "21543");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding columnartransposition");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding columnartransposition");
                 
    }
}
?>
