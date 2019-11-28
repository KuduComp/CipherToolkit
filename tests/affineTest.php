<?php

use PHPUnit\Framework\TestCase;
use cipher\affinecipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class AffineTest extends TestCase
{
    public function testAffinne()
    {
        // Test affine
        $c = new affinecipher(UPPER_ALPHABET, 5, 5);
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("WOZHBTPDKMXLSEXQYBNCRXGZMWOZIFAVUXJ",$res, "Error encoding affine");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding caesar");
        
    }
}
?>
