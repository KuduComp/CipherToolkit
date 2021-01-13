<?php

use PHPUnit\Framework\TestCase;
use cipher\redefencecipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class RedefenceTest extends TestCase
{
    public function testRedefence ()
    {
        // Test redefencecipher
        $pt = "thequickbrownfoxjumpsoverthelazydog";
		$ct = "hkrxuetyotbjrdqiwfpoeaecoomvhzgunsl";
		$c = new redefencecipher (UPPER_ALPHABET, 5, 0, [1, 0, 3, 2, 4]);

        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding redefencecipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding redefencecipher");

		$c->setoffset (2);
		$ct = "ikfxoeaycovzhqrwupteotubnjsrldeomhg";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding redefencecipher offset 2");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding redefencecipher offset 2");

		$c->setoffset (6);
		$ct = "hqrwupteoeomhgikfxoeaytubnjsrldcovz";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding redefencecipher offset 6");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding redefencecipher offset 6");
    }
}
 
?>
