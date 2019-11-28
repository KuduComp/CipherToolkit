<?php

use PHPUnit\Framework\TestCase;
use cipher\ragbabycipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class RagbabyTest extends TestCase
{
    public function testRagbaby()
    {
        // Test caesar
        $pt = "THE QUICK BROWN FOW IUMPS OVER THE LAZY DOG";
		$ct = "ULC UYPLL KEKSY MKS QRWGI CSLF RUM WNDD TIH";

        $c = new ragbabycipher ("ABCDEFHIKLMNOPQRSTUVWYZ", "GROSBEAK", 25);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding amsco");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding amsco");
                 
    }
}
?>
