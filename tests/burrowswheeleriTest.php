<?php

use PHPUnit\Framework\TestCase;
use cipher\burrowswheelercipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class BurrowsWheelerTest extends TestCase
{
    public function testBurrowsWheeler ()
    {
        // Test burrowswheelercipher
        $pt = "thequickbrownfoxjumpsoverthelazydog";
		$ct = "lkiyhhvnottuxceuwdsrfmebepr|qjooozag";
		$c = new burrowswheelercipher (UPPER_ALPHABET, "|");

        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding burrowswheelercipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding burrowswheelercipher");

        $pt = "toentomatentomatentomatentovrat";
		$ct = "mmmrotttoooeeeetttttvaaa|nnnnaot";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding burrowswheelercipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding burrowswheelercipher");

    }
}
?>
