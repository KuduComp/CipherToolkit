<?php

use PHPUnit\Framework\TestCase;
use cipher\polyalphabeticcipher\vigenerecipher;
use cipher\polyalphabeticcipher\keyedvigenerecipher;

class VigenereTest extends TestCase

{
    public function testVigenere()
    {
        $c = new vigenerecipher("abcdefghijklmnopqrstuvwxyz","longkeyword");
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("evrwemagpirhbsuhnsidjrgsezrijwnpgzu",$res, "Error encoding vigenere");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding vigenere");
    }
    
    public function testKeyedVigenere()
    {
        $c = new keyedvigenerecipher("abcdefghijklmnopqrstuvwxyz", "zwartepiet", "sinterklaas");
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("sdehnmrsfknsnwhbycqirkvvkxwmptyudfz",$res, "Error encoding keyed vigenere");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding keyed vigenere");
    }
}
