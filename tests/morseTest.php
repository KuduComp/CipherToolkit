<?php

use PHPUnit\Framework\TestCase;
use cipher\multisubstitutioncipher\morsecode;

class MorseTest extends TestCase

{
    public function testMorse()
    {
        $c = new morsecode();
        $c->setsep("/");
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("-/...././--.-/..-/../-.-./-.-/-.../.-./---/.--/-./..-./---/-..-/.---/..-/--/.--./.../---/...-/./.-./-/...././.-../.-/--../-.--/-../---/--.",$res, "Error encoding morse");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding morse");
    }
}
