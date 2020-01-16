<?php

use PHPUnit\Framework\TestCase;
use cipher\hillcipher;

//All test files must be named *Test.php (case sensitive T)

class HillTest extends TestCase
{
    public function testHill ()
    {
        // Test hillcipher
		$keys = array ("PAEER", "AKIWI", "APXAL", "SINSA", "KLMNO");
	
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		$ct = "JFLNUS!MSJ?YAUQDZGFHVKK?G!ZXKXXLCFE";
		$c = new hillcipher ("ABCDEFGHIJKLMNOPQRSTUVWXYZ!?.", $keys);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding hillcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding hillcipher");
                 
    }
}
?>
