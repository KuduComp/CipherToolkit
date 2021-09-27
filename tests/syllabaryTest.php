<?php

use PHPUnit\Framework\TestCase;
use cipher\syllabarycipher;

//All test files must be named *Test.php (case sensitive T)

class SyllabaryTest extends TestCase
{
    public function testSyllabary()
    {
        // Test zebracipher
        $c = new syllabarycipher();
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123");
        $this->assertEquals("87699243145311769559356397519257687763947087559998206337011215",$res, "Error encoding syllabary");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123",$res, "Error decoding syllabary");
        
        // With key
        $c->setkey("REPLACING");
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123");
        $this->assertEquals("87709247035617769561396597549259017765947187029998246541071804",$res, "Error encoding syllabary unknown key");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123",$res, "Error decoding syllabary unknown key");
        
        // With specific coordinates
        $c->setcoordinates("0246813579", "9753184620");
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123");
        $this->assertEquals("76599586031426549837603896119510075638915776059092413887062201",$res, "Error encoding syllabary unknown coordinates");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123",$res, "Error decoding syllabary unknown coordinates");
        }
}
?>
