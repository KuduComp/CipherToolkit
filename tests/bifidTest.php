<?php

use PHPUnit\Framework\TestCase;
use cipher\polybiuscipher\bifidcipher;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

class BifidTest extends TestCase

{
    public function testBifid()
    {
        $c = new bifidcipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ","STILLGOTTHEBLUES");
        $res = $c->encode ("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG");
        $this->assertEquals("TBODBUPUTQTWMHIZCTERCYVHMDVASKHFGPG",$res, "Error encoding bifid");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$res, "Error decoding bifid");
    }
}

?>

