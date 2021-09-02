<?php

use PHPUnit\Framework\TestCase;
use cipher\zebracipher;

//All test files must be named *Test.php (case sensitive T)

class ZebraTest extends TestCase
{
    public function testCaesar()
    {
        // Test zebracipher
        $c = new zebracipher();
        $res = $c->encode ("THE1QUICK2BROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("69531891118961712445589222894262587535058765471576064587449695315607877465851",$res, "Error encoding zebra");
        $res = $c->decode ($res);
        $this->assertEquals("THE1QUICK2BROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding zebra");        
    }
}
?>
