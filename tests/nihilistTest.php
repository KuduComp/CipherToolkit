<?php

use PHPUnit\Framework\TestCase;
use cipher\nihilistcipher;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

//require_once __DIR__ . '/../vendor/autoload.php';

class NihilistTest extends TestCase

{
    public function testNihilistX()
    {
        $c = new nihilistcipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ","ANIMAL");
		$msg = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		$res = $c->encode ($msg);
		$this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error encoding nihilist");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding nihilist");

    }
}
