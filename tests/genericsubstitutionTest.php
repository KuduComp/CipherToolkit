<?php

use PHPUnit\Framework\TestCase;
use cipher\genericsubstitutioncipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class GenericsubTest extends TestCase
{
    public function testGenericsub()
    {
        // Test genericsubstitutioncipher
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "NOIHPQEUCJDTBKDVSPYFLDRIJNOIWAZXGDM";
		
        $c = new genericsubstitutioncipher(UPPER_ALPHABET, "ACEGIKMOQSUWYBDFHJLNPRTVXZ");

        $res = $c->encode ($pt);
        $this->assertEquals($ct, $res, "Error encoding genericsubstitutioncipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt, $res, "Error decoding genericsubstitutioncipher");
                 
    }
}

?>
