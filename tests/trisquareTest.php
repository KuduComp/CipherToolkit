<?php

use PHPUnit\Framework\TestCase;
use cipher\trisquarecipher;
use const \cipher\UPPER_ALPHABET_REDUCED;

class TrisquareTest extends TestCase
{
    public function testTrisquare()
    {
        // Test condicipher
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOGX";
		$ct = "OSIZARZTKNKFBBQIGXSFGDHZDERWPBNTNAYDBTUNOBFPMPYYDDNRNW";
        $c = new trisquarecipher(UPPER_ALPHABET_REDUCED, "ABCDEFGHIKLMNOPQRSTUVWXYZ", 
                                 "FGHIKLMNOABCDEPQRSTUVWXYZ", "ABCDKLMNOEFGHIPQRSTUVWXYZ");
        $res = $c->encode ($pt);
        // No assertion possible as each triplet contains 2 random characters
        // $this->assertEquals($ct,$res, "Error encoding trisquarecipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error en- or decoding trisquarecipher");
                 
    }
}
?>
