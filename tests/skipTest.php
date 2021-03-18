<?php

use PHPUnit\Framework\TestCase;
use cipher\skipcipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class SkipTest extends TestCase
{
    public function testAffinne()
    {
        // Test skip
        $c = new skipcipher(UPPER_ALPHABET, 9, 1);
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("TRMEHOPLEWSAQNOZUFVYIOEDCXROKJTGBUH",$res, "Error encoding skip");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding skip");
        $c->setstart(3);
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("EWSAQNOZUFVYIOEDCXROKJTGBUHTRMEHOPL",$res, "Error encoding skip, start 3");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding skip, start 3");
        
    }
}
?>
