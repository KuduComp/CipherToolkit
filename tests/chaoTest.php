<?php

use PHPUnit\Framework\TestCase;
use cipher\chaocipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class ChaoTest extends TestCase
{
    public function testChao()
    {
        // Test chaocipher
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "EWGYBTOXDNRUULNXREPLXKCLPLVYYTQJOPW";
		$left  = "ABCDEFMNOPQRSGHIJKLTUVWXYZ";
		$right = "PQRSTUVWXYZABCDEKLMNOFGHIJ";
        $c = new chaocipher(UPPER_ALPHABET, $left, $right);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding chaocipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding chaocipher");
                 
    }
}
?>
