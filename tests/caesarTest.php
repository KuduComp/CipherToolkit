<?php

use PHPUnit\Framework\TestCase;
use cipher\caesarcipher;
use cipher\atbashcipher;

//All test files must be named *Test.php (case sensitive T)

class CaesarTest extends TestCase
{
    public function testCaesar()
    {
        // Test caesar
        $c = new caesarcipher();
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("gurdhvpxoebjasbkwhzcfbiregurynmlqbt",$res, "Error encoding caesar");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding caesar");
        
        // Test atbash
        $c = new atbashcipher();
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("gsvjfrxpyildmulcqfnkhlevigsvozabwlt",$res, "Error encoding atbash");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding atbash");
        
        // Test random substitution
        // $c = new simplesubstitutioncipher();
        // $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog", "qwertyuiopasdfghjklzxcvbnm");
        // $this->assertEquals("epcaghvrxdibyniuqgzjliwcdepcsktfmio",$res, "Error encoding substitution");
        // $res = $c->decode ($res);
        // $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding substitution");
        // $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog", "foutje");
        // $this->assertEquals("Key doesnot contain enough characters",$res, "Error substitution checking alphabet");
        
    }
}
?>
