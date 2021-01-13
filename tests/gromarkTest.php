<?php

use PHPUnit\Framework\TestCase;
use cipher\gromarkcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class GromarkTest extends TestCase
{
    public function testGromark ()
    {
        // Test gromarkcipher
        $pt = "THEREAREUPTOTENSUBSTITUTESPERLETTER";
		$ct = "NFYCKBTIJCNWZYCACJNAYNLQPWWSTWPJQFL";
		
		$c = new gromarkcipher(UPPER_ALPHABET, "ENIGMA", 23452);
		
		$res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding gromarkcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding gromarkcipher");
                 
    }
}
?>
