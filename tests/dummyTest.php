<?php

use PHPUnit\Framework\TestCase;
use cipher\dummycipher;
use const cipher\UPPER_ALPHABET;

class DummyTest extends TestCase

{
    public function testDummy()
    {
        $c = new dummycipher( UPPER_ALPHABET, UPPER_ALPHABET);
    
        $res = $c->cleaninput ("THEQUICKBROWNFOXJUMPS@#OV12367123ERTHELAZYDOG");
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error cleaninput");
        
        $c->setremove(FALSE);
        $res = $c->cleaninput ("THEQUICKBROWNFOXJUMPS@#OV12367123ERTHELAZYDOG");
        $this->assertEquals("THEQUICKBROWNFOXJUMPS@#OV12367123ERTHELAZYDOG",$res, "Error cleaninput with remove is false");
        $c->setremove(TRUE);
        
        $c->setsep ("-");
        $res = $c->cleaninput ("THE-QUICK-BROWN-FOX-JUMPS-OVER-THE-LAZY-DOG", FALSE);
        $this->assertEquals("THE-QUICK-BROWN-FOX-JUMPS-OVER-THE-LAZY-DOG",$res, "Error cleaninput");
        
        $c->setsep ("");
        $res = $c->cleaninput ("THE-QUICK-BROWN-FOX-JUMPS-OVER-THE-LAZY-DOG");
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error cleaninput");

        $res = $c->cleanencodedmessage("THEQUICKBROWNFOXJUMPS@#OV12367123ERTHELAZYDOG");
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error clean encoded message");
        
        $c->setsep ("-");
        $res = $c->cleanencodedmessage ("THE-QUICK-BROWN-FOX-JUMPS-OVER-THE-LAZY-DOG", FALSE);
        $this->assertEquals("THE-QUICK-BROWN-FOX-JUMPS-OVER-THE-LAZY-DOG",$res, "Error clean encoded message");
        
        $c->setsep ("");
        $res = $c->cleanencodedmessage ("THE-QUICK-BROWN-FOX-JUMPS-OVER-THE-LAZY-DOG");
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error cleanencoded message");
 
        $res = $c->shufflealphabet(UPPER_ALPHABET, "SINTERKLAAS");
        $this->assertEquals("SINTERKLABCDFGHJMOPQUVWXYZ",$res, "Error shuffle alphabet");
        
        $c->setblock(5);
        $c->setsep(" ");
        $res = $c->formatoutput("ABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDE");
        $this->assertEquals("ABCDE ABCDE ABCDE ABCDE ABCDE ABCDE ABCDE ABCDE ABCDE ABCDE ABCDE",$res, "Error format output");
        
        $c->setsep("-");
        $res = $c->formatoutput("ABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCDEABCD");
        $this->assertEquals("ABCDE-ABCDE-ABCDE-ABCDE-ABCDE-ABCDE-ABCDE-ABCDE-ABCDE-ABCDE-ABCD",$res, "Error format output");
        
        $msg="thequickbrownfoxjumpsoverthelazydog";
        $key=array (2, 1, 0);
        $res = $c->encodecolumnartransposition ($msg, $key);
        $this->assertEquals("eibwousehadhukofjpvtlygtqcrnxmorezo",$res, "Error columnar transposition encoding");
        //eibwousehadhukofjpvtlygtqcrnxmorezo
        $res = $c->decodecolumnartransposition ($res, $key);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error columnar transposition decoding");
                
    }
}
?>
