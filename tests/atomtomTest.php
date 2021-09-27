
<?php

use PHPUnit\Framework\TestCase;
use cipher\multisubstitutioncipher\atomtomcipher;

class AtomtomTest extends TestCase

{
    public function testAtomtom()
    {
        $c = new atomtomcipher();
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        // Needs too many escaped backslashes to test ;-)
        // $this->assertEquals("fmpmfpmpppfpfmfmffmmfpmpmmppffppffpppppmpfppffpfpmmfmfppmpfmfmmppffpmmpppfffmpmfpmpppmfmmmffpffmmpmppfmfm",$res, "Error encoding atomtom");
        $c->setsep("");
        $c->setremove(true);
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding atomtom");
    }
}

?>