<?php

use PHPUnit\Framework\TestCase;
use cipher\multisubstitutioncipher\kennycode;

class KennyTest extends TestCase

{
    public function testKenny()
    {
        $c = new kennycode();
        $c->setsep("/");
        $res = $c->encode ("thequickbrownfoxjumpsoverthelazydog");
        $this->assertEquals("fmpmfpmpppfpfmfmffmmfpmpmmppffppffpppppmpfppffpfpmmfmfppmpfmfmmppffpmmpppfffmpmfpmpppmfmmmffpffmmpmppfmfm",$res, "Error encoding kenny");
        $res = $c->decode ($res);
        $this->assertEquals("thequickbrownfoxjumpsoverthelazydog",$res, "Error decoding kenny");
    }
}


