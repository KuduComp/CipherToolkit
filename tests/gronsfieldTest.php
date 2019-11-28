<?php

use PHPUnit\Framework\TestCase;
use cipher\polyalphabeticcipher\vigenerecipher\gronsfieldcipher;

class GronsfieldTest extends TestCase

{
    public function testGronsfield()
    {
        $c = new gronsfieldcipher ("ABCDEFGHIJKLMNOPQRSTUVWXYZ","975318420");
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("COJTVQGMBAVBQGWBLUVWXRWMVVHNSFCZLSI",$res, "Error encoding autokey");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding autokey");
    }
}

?>
