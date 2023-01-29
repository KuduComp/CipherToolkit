<?php

use PHPUnit\Framework\TestCase;
use cipher\newscipher;
use const cipher\UPPER_ALPHABET_REDUCED;

//All test files must be named *Test.php (case sensitive T)

class NewsTest extends TestCase
{
    public function testNews()
    {
        // Test affine
        $c = new newscipher(UPPER_ALPHABET_REDUCED, 5, 5);

        // Encode uses random function and cannot be tested
        // $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        // $this->assertEquals("XNEMNEINELSPSPNWXSFWAENSWISBNSNMNWKSWYWHEOSESNWUNOSWKSWRSWZSNSWPSWIWAWMWVSYETSKNWHSENNW",$res, "Error encoding affine");
        $res = $c->decode ("XNEMNEINELSPSPNWXSFWAENSWISBNSNMNWKSWYWHEOSESNWUNOSWKSWRSWZSNSWPSWIWAWMWVSYETSKNWHSENNW");
        $this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$res, "Error decoding news");
        
    }
}
?>
