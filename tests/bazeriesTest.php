<?php

use PHPUnit\Framework\TestCase;
use cipher\bazeriescipher;
use const \cipher\UPPER_ALPHABET_REDUCED;

class BazeriesTest extends TestCase
{
    public function testBazeries()
    {
        // Test bazeries        
        $c = new bazeriescipher(UPPER_ALPHABET_REDUCED, "", "", 3752);
       
        // Test default with square 1 vertical and square 2 uses spelled out n
	    $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
		$ct = "MFKNUPVCXEGHIDGCWQAXFKNMOGYLZTRMGBS";
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding bazeriescipher default");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding bazeriescipher default"); 
        
        // Test manually set square and n
		$ct = "MTYAVKRHDWISSLNRPXGYSOHVBMTCEVUZFSQ";
        $c->setsquares ("AFLQVBGMRWCHNSXDIOTYEKPUZ", "CLEABDFGHIKMNOPQRSTUVWXYZ");
        $c->setn (23);
        
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding bazeriescipher squares set");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding bazeriescipher squares set");
        
    }
}

?>
