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
        $res = $c->encode ("THE1QUICK2BROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("70591821181687225261822281504647635664776072636769647414705916207978546457",$res, "Error encoding tapir");
        $res = $c->decode ($res);
        $this->assertEquals("THE1QUICK2BROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding tapir");        
    }
}
?>
