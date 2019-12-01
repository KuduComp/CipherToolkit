<?php

use PHPUnit\Framework\TestCase;
use cipher\vatsyayanacipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class VatsyayanaTest extends TestCase
{
    public function testVatsyayana()
    {
        // Test Vatsyayana
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "SGFRVJDLAQPXMEPWIVNOTPUFQSGFKBYZCPH";
        $c = new vatsyayanacipher(UPPER_ALPHABET, "ACEGIKMOQSUWY", "BDFHJLNPRTVXZ");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding vatsyayanacipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding vatsyayanacipher");
                 
    }
}

?>
