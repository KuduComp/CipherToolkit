<?php
use PHPUnit\Framework\TestCase;
use cipher\skytalecipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)
class SkytaleTest extends TestCase
{
    public function testSkytale()
    {
        
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
        $ct = "TRMEHOPLEWSAQNOZUFVYIOEDCXROKJTGBUH";
        $c = new skytalecipher(UPPER_ALPHABET, 9);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding skytalecipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding skytalecipher");
                 
    }
}
?>
