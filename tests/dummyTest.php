<?php

use PHPUnit\Framework\TestCase;
use cipher\dummycipher;
use const cipher\UPPER_ALPHABET;
use const cipher\UPPER_ALPHABET_REDUCED;

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
    
    public function testFillsquare () {
        $c = new dummycipher();
        
        $pt = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "TL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square HOR TL");

        $pt = "ABCDEKIHGFLMNOPUTSRQVWXYZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "TL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square HOR TL FLIP");

        $pt = "EDCBAKIHGFPONMLUTSRQZYXWV";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "TR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square HOR TR");

        $pt = "EDCBAFGHIKPONMLQRSTUZYXWV";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "TR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square HOR TR FLIP");

        $pt = "VWXYZQRSTULMNOPFGHIKABCDE";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "BL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square HOR BL");

        $pt = "VWXYZUTSRQLMNOPKIHGFABCDE";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "BL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square HOR BL FLIP");

        $pt = "ZYXWVUTSRQPONMLKIHGFEDCBA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "BR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square HOR BR");

        $pt = "ZYXWVQRSTUPONMLFGHIKEDCBA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "HOR", "BR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square HOR BR FLIP");

        $pt = "AFLQVBGMRWCHNSXDIOTYEKPUZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "TL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square VER TL");

        $pt = "AKLUVBIMTWCHNSXDGORYEFPQZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "TL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square VER TL FLIP");

        $pt = "VQLFAWRMGBXSNHCYTOIDZUPKE";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "TR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square VER TR");

        $pt = "VULKAWTMIBXSNHCYROGDZQPFE";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "TR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square VER TR FLIP");

        $pt = "EKPUZDIOTYCHNSXBGMRWAFLQV";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "BL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square VER BL");

        $pt = "EFPQZDGORYCHNSXBIMTWAKLUV";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "BL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square VER BL FLIP");

        $pt = "ZUPKEYTOIDXSNHCWRMGBVQLFA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "BR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square VER BR");

        $pt = "ZQPFEYROGDXSNHCWTMIBVULKA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "VER", "BR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square VER BR FLIP");

        $pt = "ABDGLCEHMQFINRUKOSVXPTWYZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "TL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH TL");

        $pt = "ABFGPCEHOQDINRWKMSVXLTUYZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "TL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH TL FLIP");

        $pt = "LGDBAQMHECURNIFXVSOKZYWTP";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "TR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH TR");

        $pt = "PGFBAQOHECWRNIDXVSMKZYUTL";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "TR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH TR FLIP");

        $pt = "PTWYZKOSVXFINRUCEHMQABDGL";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "BL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH BL");

        $pt = "LTUYZKMSVXDINRWCEHOQABFGP";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "BL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH BL FLIP");

        $pt = "ZYWTPXVSOKURNIFQMHECLGDBA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "BR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH BR");

        $pt = "ZYUTLXVSMKWRNIDQOHECPGFBA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAH", "BR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAH BR FLIP");

        $pt = "ACFKPBEIOTDHNSWGMRVYLQUXZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "TL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV TL");

        $pt = "ACDKLBEIMTFHNSUGORVYPQWXZ";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "TL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV TL FLIP");       

        $pt = "PKFCATOIEBWSNHDYVRMGZXUQL";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "TR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV TR");

        $pt = "LKDCATMIEBUSNHFYVROGZXWQP";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "TR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV TR FLIP");       

        $pt = "LQUXZGMRVYDHNSWBEIOTACFKP";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "BL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV BL");

        $pt = "PQWXZGORVYFHNSUBEIMTACDKL";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "BL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV BL FLIP");       

        $pt = "ZXUQLYVRMGWSNHDTOIEBPKFCA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "BR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV BR");

        $pt = "ZXWQPYVROGUSNHFTMIEBLKDCA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "DIAV", "BR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square DIAV BR FLIP");       

        $pt = "ABCDEQRSTFPYZUGOXWVHNMLKI";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "TL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square SI TL CLOCKWISE");

        $pt = "AQPONBRYXMCSZWLDTUVKEFGHI";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "TL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square SI TL COUNTERCLOCKWISE");       

        $pt = "NOPQAMXYRBLWZSCKVUTDIHGFE";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "TR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square SI TR CLOCKWISE");

        $pt = "EDCBAFTSRQGUZYPHVWXOIKLMN";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "TR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square SI TR COUNTERCLOCKWISE");       

        $pt = "EFGHIDTUVKCSZWLBRYXMAQPON";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "BL", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square SI BL CLOCKWISE");

        $pt = "NMLKIOXWVHPYZUGQRSTFABCDE";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "BL", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square SI BL COUNTERCLOCKWISE");       

        $pt = "IKLMNHVWXOGUZYPFTSRQEDCBA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "BR", FALSE);
        $this->assertEquals($pt, $ct, "Error filling square SI BR CLOCKWISE");

        $pt = "IHGFEKVUTDLWZSCMXYRBNOPQA";
        $ct = $c->fillsquare (UPPER_ALPHABET_REDUCED, "SI", "BR", TRUE);
        $this->assertEquals($pt, $ct, "Error filling square SI BR COUNTERCLOCKWISE");       

    }
}

?>
