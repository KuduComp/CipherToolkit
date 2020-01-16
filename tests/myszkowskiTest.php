<?php

use PHPUnit\Framework\TestCase;
use cipher\myszkowskicipher;
use const cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class MyszkowskiTest extends TestCase
{
    public function testMyskowski ()
    {
        // Test myszkowskicipher
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOGX";
		$ct = "HQIKRWFXUPOETEAYOXTCNMRZEUBOOJSVHLDG";
		$c = new myszkowskicipher ("ABCDEFGHIJKLMNOPQRSTUVWXYZ!?.", "BANANA");

        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding myszkowskicipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding myszkowskicipher");
		
		$pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		$ct = "HQIKRWFXUPOETEAYOTCNMRZEUBOOJSVHLDG";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding myszkowskicipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding myszkowskicipher");

		$c->setkey("APPLEPIE");
		$pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		$ct = "TBJRDUKNXSELYCOVZQWPEHEIROFUMOTHAOG";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding myszkowskicipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding myszkowskicipher");
                 
		$pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYRABBITS";
		$ct = "TBJRRUKNXSELYICOVZSQWPEBHEIROFUMOTHAABT";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding myszkowskicipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding myszkowskicipher");
    }
}
?>
