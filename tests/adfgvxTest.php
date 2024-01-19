<?php

use PHPUnit\Framework\TestCase;
use cipher\polybiuscipher\ADFGVXcipher;


class ADFGVXTest extends TestCase

{
    public function testADFGVX()
    {
        $c = new ADFGVXcipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ","", "PILOTEN");
		$c->addreplacement ("j","i");
		$msg = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		$msg = $c->cleaninput ($msg);
		$this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$msg, "Error replacing J with I");
		$res = $c->encode ($msg);
		$this->assertEquals("XADDGGXAXDGGXXGFGGAADXADXDXGAGGFFAGFGXXDFDDFFFADAFGADGFXFDFGAGGFDXAFXG",$res, "Error encoding ADFGX");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG",$res, "Error decoding ADFGX");
        $c = new ADFGVXcipher ("A1B2C3D4E5F6G7H8I9J0KLMNOPQRSTUVWXYZ", "", "PILOTEN");
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123");
        $this->assertEquals("FAGDAVFDXFXXXFXAGAVGDDFAAFXVXXAAAVVVVXVVFXAFFFGGVDFAVGVFGAVAVGGVADVVXGDDFXAA",$res, "Error encoding ADFGVX");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG123",$res, "Error decoding ADFGX");
    }
}

