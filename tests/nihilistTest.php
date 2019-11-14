<?php

use PHPUnit\Framework\TestCase;
use cipher\polybiuscipher\nihilistcipher;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

//require_once __DIR__ . '/../vendor/autoload.php';

class NihilistTest extends TestCase

{
    public function testNihilist()
    {
        $c = new nihilistcipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ","ZEBRAS", "SCHAPEN");
	$msg = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
	$res = $c->encode ($msg);
	$this->assertEquals("66 53 43 59 94 44 63 54 35 45 57 96 53 65 63 76 63 66 78 55 62 63 74 43 29 88 43 53 55 37 42 70 66 54 66",$res, "Error encoding nihilist");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$res, "Error decoding nihilist");
	    
	$c->setaddkey ("KABOUTER";
	$res = $c->encode ($msg);
	$this->assertEquals("78 46 25 86 102 77 34 47 46 29 55 95 92 69 54 68 65 66 48 85 72 87 64 26 47 60 44 54 85 60 23 69 56 57 38",$res, "Error encoding nihilist");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$res, "Error decoding nihilist");
	
    }
}
