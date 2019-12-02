<?php

use PHPUnit\Framework\TestCase;
use cipher\portaxcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class PortaxTest extends TestCase
{
    public function testPortax ()
    {
        // Test Vatsyayana
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOGX";
        $ct = "OLFVUCMCZHPITAWUGPAZCUBOZZGKMCJMFCET";
        $c = new portaxcipher(UPPER_ALPHABET, "SPRUIT");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding portaxcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding portaxcipher");
                 
    }
}

?>
