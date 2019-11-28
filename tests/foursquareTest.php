<?php

use PHPUnit\Framework\TestCase;
use cipher\foursquarecipher;
use const \cipher\UPPER_ALPHABET_REDUCED;

//All test files must be named *Test.php (case sensitive T)

class FoursquareTest extends TestCase
{
    public function testFoursquare()
    {
        // Test caesar
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOGX";
        $ct = "PSKQQTUMANGYFMHYDPLCQFZDQNDEFDYZOIRV";
        $c = new foursquarecipher(UPPER_ALPHABET_REDUCED, "KABOUTER","DWERGHAMSTER");
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding foursquare");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding foursquare");
                 
    }
}

?>
