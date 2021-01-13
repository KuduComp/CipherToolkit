<?php

use PHPUnit\Framework\TestCase;
use cipher\alberticipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class AlbertiTest extends TestCase
{
    public function testAlberti ()
    {
        // Test alberticipher
		$plaindisc  = "ABCDEFGILMNOPQRSTVXZ1234";
		$cipherdisc = "gklnprtuz&xysomqihfdbace";
		$nullchars = "1234";

		$c = new alberticipher ($plaindisc, $cipherdisc, $nullchars);

		$pt = "gIL1DVCEmE3MORTO";
		$ct = "AuzbnhlpRfsekptk";
		$index = "g";

        $res = $c->encode ($pt, 1, $index);
        $this->assertEquals($ct,$res, "Error encoding alberticipher method 1");

		$pt = "ILDVCEEMORTO";
        $res = $c->decode ($ct, 1, $index);
        $this->assertEquals($pt,$res, "Error decoding alberticipher method 1");

		$pt = "mLAGVERA3SIFARA";	
		$ct = "mcmbufpmsndhsls";
		$index = "A";

        $res = $c->encode ($pt, 2, $index);
        $this->assertEquals($ct, $res, "Error encoding alberticipher method 2");

		$pt = "LAGVERASIFARA";
        $res = $c->decode ($ct, 2, $index);
        $this->assertEquals($pt, $res, "Error decoding alberticipher method 2");

		$plaindisc  = "ABCDEFGILMNOPQRSTVXZ1234";	
		$cipherdisc = "c&bmdgpfznxyvtoskerlhaiq";
		$c->setcipherdisc ($cipherdisc);
		$index = 0;
		
		$pt = "TEQVICBROVNFOX";
		$ct = "kdtezmbstlvfoa";
        $res = $c->encode ($pt, 3, $index, 4, 1);
        $this->assertEquals($ct, $res, "Error encoding alberticipher method 3");
        $res = $c->decode ($ct, 3, $index, 4, 1);
        $this->assertEquals($pt, $res, "Error decoding alberticipher method 3");

    }
}
 
?>
