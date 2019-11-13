<?php

use PHPUnit\Framework\TestCase;
use cipher\polybiuscipher;
use const cipher\UPPER_ALPHABET_REDUCED;

//All test files must be named *Test.php (case sensitive T)
//Composer generated autoload

class PolybiusTest extends TestCase

{
    public function testPolybius()
    {
        $c = new polybiuscipher (UPPER_ALPHABET_REDUCED,"12345", "12345");
		$res = $c->encode ("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG");
        $this->assertEquals("44 23 15 41 45 24 13 25 12 42 34 52 33 21 34 53 24 45 32 35 43 34 51 15 42 44 23 15 31 11 55 54 14 34 22",$res, "Error encoding ADFGX");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$res, "Error decoding ADFGX");
    }
}