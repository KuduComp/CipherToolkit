<?php

use PHPUnit\Framework\TestCase;
use cipher\polybiuscipher\bifidcipher;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

class BifidTest extends TestCase

{
    public function testBifid()
    {
        
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
        $ct = "TBODBUPUTQTWMHIZCTERCYVHMDVASKHFGPG";
        $c = new bifidcipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ","STILLGOTTHEBLUES");
        $res = $c->encode ($pt);
        $this->assertEquals ($ct, $res, "Error encoding bifid");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding bifid");
    }
}

?>

