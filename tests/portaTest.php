<?php

use PHPUnit\Framework\TestCase;
use cipher\portacipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class PortaTest extends TestCase
{
    public function testPorta()
    {
        // Test caesar
		
		$pt = "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG";
		$ct = "BUR JKRRS PKGCJ UJK WAWGD GHYJ MYT QNME NFV";
        
        $c = new portacipher(UPPER_ALPHABET, "KABOUTERDORPJE");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding portacipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding portacipher");
                 
    }
}
?>
