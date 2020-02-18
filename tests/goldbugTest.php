<?php

use PHPUnit\Framework\TestCase;
use cipher\goldbugcipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class GoldbugTest extends TestCase
{
    public function testGoldbug ()
    {
        // Test goldbugcipher
		$c = new goldbugcipher ();
		$c->setremove(FALSE);

		$pt = "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG";
		$ct = ";48 $?6-7 2(‡]* 1‡¢ ,?9.) ‡¶8( ;48 05[: †‡3";

        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding goldbugcipher method 1");

        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding goldbugcipher method 1");

    }
}
 
?>
