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
	$pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
	$ct = "44 23 15 41 45 24 13 25 12 42 34 52 33 21 34 53 24 45 32 35 43 34 51 15 42 44 23 15 31 11 55 54 14 34 22";
	    
        $c = new polybiuscipher (UPPER_ALPHABET_REDUCED,"12345", "12345");
	$c->setsep(" ");
	$res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding ADFGX");
        $c->setsep("");
	$res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding ADFGX");
	
    }
}

?>
