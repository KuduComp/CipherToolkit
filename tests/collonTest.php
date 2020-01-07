<?php

use PHPUnit\Framework\TestCase;
use cipher\colloncipher;
use const \cipher\UPPER_ALPHABET_REDUCED;

class CollonTest extends TestCase
{
    public function testCollon()
    {
        // Test colloncipher
        $pt = "THEQUICKBROWNFOXIUMPSOVERTHELAZYDOG";
        $c = new colloncipher(UPPER_ALPHABET_REDUCED);

		    $ct = "QFAYXZQQFVZYAFAXZWQLVWYWLFLXVYVFQXYZLLQWZXLVAYVZQQFWYXALAZVVVVAZYYLFYW";
        $res = $c->encode ($pt, 3, "RFCL");
        $this->assertEquals($ct,$res, "Error encoding colloncipher RFCL");
        $res = $c->decode ($ct, 3, "RFCL");
        $this->assertEquals($pt,$res, "Error decoding colloncipher RFCL");
                 
		    $ct = "UKEYXZUUKVZYEKEXZWUPZWYWPKPXVYZKUXYZPPUWZXPZEYVZUUKWYXEPEZVVZZEZYYPKYW";
        $res = $c->encode ($pt, 3, "RLCL");
        $this->assertEquals($ct,$res, "Error encoding colloncipher RLCL");
        $res = $c->decode ($ct, 3, "RLCL");
        $this->assertEquals($pt,$res, "Error decoding colloncipher RLCL");
                 
		    $ct = "QFADCEQQFAEDAFACEBQLVBDBLFLCADVFQCDELLQBECLVADAEQQFBDCALAEAAVVAEDDLFDB";
        $res = $c->encode ($pt, 3, "RFCF");
        $this->assertEquals($ct,$res, "Error encoding colloncipher RFCF");
        $res = $c->decode ($ct, 3, "RFCF");
        $this->assertEquals($pt,$res, "Error decoding colloncipher RFCF");
                 
		    $ct = "UKEDCEUUKAEDEKECEBUPZBDBPKPCADZKUCDEPPUBECPZEDAEUUKBDCEPEEAAZZEEDDPKDB";
        $res = $c->encode ($pt, 3, "RLCF");
        $this->assertEquals($ct,$res, "Error encoding colloncipher RLCF");
        $res = $c->decode ($ct, 3, "RLCF");
        $this->assertEquals($pt,$res, "Error decoding colloncipher RLCF");
                  
		    $ct = "YXZUKEVZYUUKXZWEKEWYWUPZXVYPKPXYZZKUWZXPPUYVZPZEWYXUUKZVVEPEZYYZZEYWPK";
        $res = $c->encode ($pt, 3, "CLRL");
        $this->assertEquals($ct,$res, "Error encoding colloncipher CLRL");
        $res = $c->decode ($ct, 3, "CLRL");
        $this->assertEquals($pt,$res, "Error decoding colloncipher CLRL");
       
		    $ct = "YXZQFAVZYQQFXZWAFAWYWQLVXVYLFLXYZVFQWZXLLQYVZLVAWYXQQFZVVALAZYYVVAYWLF";
        $res = $c->encode ($pt, 3, "CLRF");
        $this->assertEquals($ct,$res, "Error encoding colloncipher CLRF");
        $res = $c->decode ($ct, 3, "CLRF");
        $this->assertEquals($pt,$res, "Error decoding colloncipher CLRF");
       
		    $ct = "DCEQFAAEDQQFCEBAFABDBQLVCADLFLCDEVFQBECLLQDAELVABDCQQFEAAALAEDDVVADBLF";
        $res = $c->encode ($pt, 3, "CFRF");
        $this->assertEquals($ct,$res, "Error encoding colloncipher CFRF");
        $res = $c->decode ($ct, 3, "CFRF");
        $this->assertEquals($pt,$res, "Error decoding colloncipher CFRF");
       
		    $ct = "DCEAEUKEUUDCEBBKEKEUDBCADPZPKPCDEBEZKUPPCDAEBUPZEUDCEAAUKEPEEDDDBZZEPK";
        $res = $c->encode ($pt, 5, "CFRL");
        $this->assertEquals($ct,$res, "Error encoding colloncipher CFRL n=5");
        $res = $c->decode ($ct, 5, "CFRL");
        $this->assertEquals($pt,$res, "Error decoding colloncipher CFRL n=5");
       
    }
}

?>
