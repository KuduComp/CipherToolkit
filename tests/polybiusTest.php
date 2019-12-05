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
	$ct = "4423154145241325124234523321345324453235433451154244231531115554143422";
	    
        $c = new polybiuscipher (UPPER_ALPHABET_REDUCED,"12345", "12345");
	$res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding polybius row then column");
	$res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding polybius row then column");
	    
	$ct = "4432511454423152212443253312433542542353344315512444325113115545414322";
	$c->sethorizontal (FALSE);
	$res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding polybius column then row");
        $c->setsep("");
	$res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding polybius column then row");
    }
}

?>
