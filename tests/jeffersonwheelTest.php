<?php

use PHPUnit\Framework\TestCase;
use cipher\amscocipher;
use const \cipher\UPPER_ALPHABET;
use cipher\jeffersonwheelcipher;

//All test files must be named *Test.php (case sensitive T)

class JeffersonwheelTest extends TestCase
{
    public function testJeffersonwheel()
    {
        // Test caesar
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "QFPVKXFCXQHOCAWCXIIEJTDCCQFPKFHDXIH";
        $c = new jeffersonwheelcipher();
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding jeffersonwheel");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding jeffersonwheel");
        
        $c->setoffset(2);
        $ct = "KIHPDLMVWSUAJOFSDWRSMYTHQKIHMNWUAVO";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding jeffersonwheel");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding jeffersonwheel");  
                 
    }
}
?>
