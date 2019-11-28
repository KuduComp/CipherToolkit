<?php

use PHPUnit\Framework\TestCase;
use cipher\amscocipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class AmscoTest extends TestCase
{
    public function testAmsco()
    {
        // Test caesar
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "EKBOPSHYDIOWUVEAGTHCNFMRTZQURXJOELO";
        $c = new amscocipher(UPPER_ALPHABET, 3142);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding amsco");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding amsco");
                 
    }
}
?>
