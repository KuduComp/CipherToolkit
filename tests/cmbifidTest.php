<?php

use PHPUnit\Framework\TestCase;
use cipher\cmbifidcipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class CmbifidTest extends TestCase
{
    public function testCmbifid()
    {
        // Test cmbifidcipher

        $pt = "ODDPERIODSAREPOPULAR";
		$ct = "FANXZEXFENUKKRBYNKAK";
		
        $c = new cmbifidcipher("EXTRAKLMPOHWZQDGVUSIFCBYN", "NCDRSOBFQUVAGPWEYHMXLTIKZ", 7);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding cmbifidcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding cmbifidcipher");
                 
    }
}
?>
