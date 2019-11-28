<?php

use PHPUnit\Framework\TestCase;
use cipher\straddlingcheckerboardcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class straddlingcheckboardTest extends TestCase
{
    public function testStraddlingcheckboard()
    {
        // Test straddlingcheckboardcipher
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOGX";
        $ct = "63487153530029474393247535538707247389634837177763143375";
        $c = new straddlingcheckerboardcipher(UPPER_ALPHABET, "KABOUTER", 3, 7);
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding straddlingcheckboard");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding straddlingcheckboard");
		
		$colkey = array(9,8,7,6,1,2,3,4,5,0);
		$c->setboard ("KABOUTER", 2, 8, $colkey, TRUE);
		$ct = "042105880322290906000181202701822203258987018605000421052407848328012682";
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding straddlingcheckboard");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding straddlingcheckboard");
		         
    }
}

?>
