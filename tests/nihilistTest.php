<?php

use PHPUnit\Framework\TestCase;
use cipher\polybiuscipher\nihilistcipher;

//All test files must be named *Test.php (case sensitive T)

class NihilistTest extends TestCase

{
    public function testNihilist()
    {
	$pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
	$ct = "665343599444635435455796536563766366785562637443298843535537427066546";
	    
        $c = new nihilistcipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ","ZEBRAS", "SCHAPEN");
	$res = $c->encode ($pt);
	$this->assertEquals($ct, $res, "Error encoding nihilist");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding nihilist");
	
    }
}
