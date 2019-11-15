<?php

use PHPUnit\Framework\TestCase;
use cipher\polyalphabeticcipher\vigenerecipher\beaufortcipher;

class BeaufortTest extends TestCase
{
    public function testBeaufort()
    {
        $c = new beaufortcipher("abcdefghijklmnopqrstuvwxyz","kabouter");
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("rtxyalchjjnshoqubgpzcfjnthukjtfthmv",$res, "Error encoding Beaufort");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding Beaufort");
    }

}
