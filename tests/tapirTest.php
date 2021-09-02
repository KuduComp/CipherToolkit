<?php

use PHPUnit\Framework\TestCase;
use cipher\tapircipher;

//All test files must be named *Test.php (case sensitive T)

class TapirTest extends TestCase
{
    public function testCaesar()
    {
        // Test tapircipher
        $c = new tapircipher();
        $res = $c->encode ("the1quick2brownfoxjumpsoverthelazydog");
        $this->assertEquals("70591821181687225261822281504647635664776072636769647414705916207978546457",$res, "Error encoding tapir");
        $res = $c->decode ($res);
        $this->assertEquals("the1quick2brownfoxjumpsoverthelazydog",$res, "Error decoding tapir");        
    }
}
?>
