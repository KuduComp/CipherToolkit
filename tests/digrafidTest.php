<?php

use PHPUnit\Framework\TestCase;
use cipher\digrafidcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class DigrafidTest extends TestCase
{
    public function testDigrafid ()
    {
        // Test Digrafid
        $pt = "THISISTHEFORESTPRI";
        $ct = "HjMxWsWjAdWgFcSpYi";
        $c = new digrafidcipher(UPPER_ALPHABET . "#", "KEYWORD", "VERTICAL");
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding digrafidcipher fraction 3");
        $res = strtoupper($c->decode ($ct));
        $this->assertEquals($pt, $res, "Error decoding digrafidcipher fraction 3");

		$ct = "HjTkVhYuFfWdSqYpRi";
		$c->setFraction (4);
        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding digrafidcipher fraction 4");
        $res = strtoupper($c->decode ($ct));
        $this->assertEquals($pt, $res, "Error decoding digrafidcipher fraction 4");
		
    }
}

?>
