<?php

use PHPUnit\Framework\TestCase;
use cipher\zygazyfacipher;
use const \cipher\UPPER_ALPHABET;
//All test files must be named *Test.php (case sensitive T)

class ZygazyfaTest extends TestCase
{
    public function testZygazyfa()
    {
        // Test zygazyfacipher
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		    $ct = "DJPVDOZVDHUCSPJQZELYVPWVYOKFWRYOUNX";
        $c = new zygazyfacipher(UPPER_ALPHABET, "RAYCROWTHER");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding zygazyfacipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding zygazyfacipher");
                 
    }
}
?>
