<?php

use PHPUnit\Framework\TestCase;
use cipher\bazeriescipher;
use const \cipher\UPPER_ALPHABET;

class BazeriesTest extends TestCase
{
    public function testBazeries()
    {
        // Test condicipher
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
		    $ct = "MTYAVKRHDWISSLNRPXGYSOHVBMTCEVUZFSQ";
        
        $c = new bazeriescipher(UPPER_ALPHABET_REDUCED);
        $c->setsquares ("AFLQVBGMRWCHNSXDIOTYEKPUZ", "CLEABDFGHIKMNOPQRSTUVWXYZ");
        $c->setn (23);
        
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding bazeriescipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding bazeriescipher");           
    }
}

?>
