<?php

use PHPUnit\Framework\TestCase;
use cipher\polyalphabeticcipher\vigenerecipher\autokeycipher;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

class AutokeyTest extends TestCase

{
    public function testAutokey()
    {
        $c = new autokeycipher ("ABCDEFGHIJKLMNOPQRSTUVWXYZ","QUEENLY");
        $res = $c->encode ("ATTACKATDAWN");
        $this->assertEquals("QNXEPVYTWTWP",$res, "Error encoding autokey");
        $res = $c->decode ($res);
        $this->assertEquals("ATTACKATDAWN",$res, "Error decoding autokey");
    }
}

?>
