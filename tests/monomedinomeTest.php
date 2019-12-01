<?php

use PHPUnit\Framework\TestCase;
use cipher\monomedinomecipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class MonomedinomeTest extends TestCase
{
    public function testMonomedinome()
    {
        // Test monomedinome J=I Z=Y
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAYYDOG";
        $ct = "7452324647424041031353813137474636853139207452963030483149";
        $c = new monomedinomecipher("ABCDEFGHIKLMNOPQRSTUVWXY", "APFELSTRUDEL", "KIRSCHTORTE");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding monomedinome");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding monomedinome");
                 
    }
}
?>
