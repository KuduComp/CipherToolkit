<?php

use PHPUnit\Framework\TestCase;
use cipher\periodicgromarkcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class PeriodicgromarkTest extends TestCase
{
    public function testPeriodicgromark ()
    {
        // Test gromarkcipher
        $pt = "WINTRYSHOWERSWILLCONTINUEFORTHENEXTFEWDAYSACCORDINGTOTHEFORECAST";
		$ct = "RHNAAXNRUZBNIUARXCRTPATBRLIGDSVCIRCVOYPVRAAZZMUSREQYEVMMURGWTLUD";

		$c = new periodicgromarkcipher(UPPER_ALPHABET, "ENIGMA", 23452);
		
		$res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding periodicgromarkcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding periodicgromarkcipher");
                 
    }
}
?>
