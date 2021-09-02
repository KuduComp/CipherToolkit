<?php

use PHPUnit\Framework\TestCase;
use cipher\zebracipher;

//All test files must be named *Test.php (case sensitive T)

class TapirTest extends TestCase
{
    public function testCaesar()
    {
        // Test tapircipher
        $c = new zebracipher();
        $res = $c->encode ("the1quick2brownfoxjumpsoverthelazydog");
        $this->assertEquals("69531891118961712445589222894262587535058765471576064587449695315607877465851",$res, "Error encoding tapir");
        $res = $c->decode ($res);
        $this->assertEquals("the1quick2brownfoxjumpsoverthelazydog",$res, "Error decoding tapir");        
    }
}
?>
