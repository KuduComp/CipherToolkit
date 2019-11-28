<?php

use PHPUnit\Framework\TestCase;
use cipher\nihilisttranspositioncipher;
use const \cipher\UPPER_ALPHABET;

class OTPTest extends TestCase
{
    public function testOTP()
    {
        // Test caesar
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOGA";
        $ky = "213645";
        $ct = "QTYZUHBCIGGIAMGRSQUASXEQVPHYAWAUCXG";
        $c = new nihilisttranspositioncipher(UPPER_ALPHABET, $ky);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding nihilisttranspositioncipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding nihilisttranspositioncipher");

    }
}

?>
