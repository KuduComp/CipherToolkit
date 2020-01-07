<?php

use PHPUnit\Framework\TestCase;
use cipher\phillipscipher;
use const \cipher\UPPER_ALPHABET_REDUCED;

class PhillipsTest extends TestCase
{
    public function testPhillips()
    {
        // Test condicipher
        $pt = "THETHINGSTHATCOMETOTHOSEWHOWAITMAYBETHETHINGSLEFTBYTHOSEWHOGOTTHEREFURST";
	    $ct = "DRNDRMAQZLTRSKWOVYAYRWZNTBWTKMLOKEYGLRGLRFHQZUGPLIFSTWZVBRAQWDDRNYGOMYFL";
        $c = new phillipscipher(UPPER_ALPHABET_REDUCED, "PATIENCE");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding phillipscipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding phillipscipher");
                 
    }
}

?>
