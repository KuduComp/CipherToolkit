<?php

use PHPUnit\Framework\TestCase;
use cipher\onetimepadcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class OTPTest extends TestCase
{
    public function testOTP()
    {
        // Test caesar
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ky = "DOGRABBITLIONTIGRESPARROWEAGLEZEBRA";
		$ct = "QTYZUHBCIGGIAMGRSQUASXEQVPHYAWAUCXG";
        $c = new onetimepadcipher(UPPER_ALPHABET, $ky);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding onetimepadcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding onetimepadcipher");
                 
    }
}

?>
