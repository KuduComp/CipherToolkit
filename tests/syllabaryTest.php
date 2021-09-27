<?php

use PHPUnit\Framework\TestCase;
use cipher\syllabarycipher;

//All test files must be named *Test.php (case sensitive T)

class SyllabaryTest extends TestCase
{
    public function testSyllabary()
    {
        // Test zebracipher
        $c = new syllabarycipher("ZEBRAISKING");
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123");
        $this->assertEquals("88719348210703779661406598549359707865957288570099276542100422",$res, "Error encoding syllabary");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123",$res, "Error decoding syllabary");
        
        // With specific coordinates
        $c->setcoordinates("0246813579", "9753184620");
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123");
        $this->assertEquals("72579382470603569437893892119310595238985572160990463885290145",$res, "Error encoding syllabary unknown coordinates");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123",$res, "Error decoding syllabary unknown coordinates");
        }
}
?>
