<?php

use PHPUnit\Framework\TestCase;
use cipher\trifidcipher;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

class TrifidTest extends TestCase

{
    public function testTrifid()
    {

        $pt = "DITISGEHEIM";
        $ct = "YVCYQKNRZBW";
        $c = new trifidcipher ("ABCDEFGHIJKLMNOPQRSTUVWXYZ_","LEONARDVIC");
        $res = $c->encode ($pt);
        $this->assertEquals ($ct, $res, "Error encoding trifid");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding trifid");
    }
}

?>
