<?php

use PHPUnit\Framework\TestCase;
use cipher\railfencecipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class RailfenceTest extends TestCase
{
    public function testRailfence ()
    {
        // Test railfencecipher
        $pt = "thequickbrownfoxjumpsoverthelazydog";
		$ct = "tbjrdhkrxuetyoecoomvhzgqiwfpoeaunsl";
		$c = new railfencecipher (UPPER_ALPHABET, 5, 0);

        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding railfencecipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding railfencecipher");

		$c->setoffset (2);
		$ct = "covzikfxoeaytubnjsrldhqrwupteoeomhg";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding railfencecipher offset 2");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding railfencecipher offset 2");

		$c->setoffset (6);
		$ct = "eomhghqrwupteotubnjsrldikfxoeaycovz";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding railfencecipher offset 6");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding railfencecipher offset 6");
    }
}
 
?>
