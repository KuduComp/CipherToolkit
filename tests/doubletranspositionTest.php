<?php

use PHPUnit\Framework\TestCase;
use cipher\doubletranspositioncipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class DoubleTranspositionTest extends TestCase
{
    public function testDoubleTransposition()
    {
        
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "BOPTHJIOUTZOKNQLUCDVWRXHAEEFMRGESOY";
        $c = new doubletranspositioncipher(UPPER_ALPHABET, "ALADIN", "CONSPIRACY");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding doubletranspositioncipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding doubletranspositioncipher");
                 
    }
}

?>

