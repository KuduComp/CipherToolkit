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
        $c = new colloncipher(UPPER_ALPHABET_REDUCED, "RFCL", "", 3);

		    $ct = "QFAYXZQQFVZYAFAXZWQLVWYWLFLXVYVFQXYZLLQWZXLVAYVZQQFWYXALAZVVVVAZYYLFYW";
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher RFCL");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher RFCL");

		    $ct = "UKEYXZUUKVZYEKEXZWUPZWYWPKPXVYZKUXYZPPUWZXPZEYVZUUKWYXEPEZVVZZEZYYPKYW";
        $c->setmethod("RLCL");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher RLCL");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher RLCL");

		    $ct = "QFADCEQQFAEDAFACEBQLVBDBLFLCADVFQCDELLQBECLVADAEQQFBDCALAEAAVVAEDDLFDB";
        $c->setmethod("RFCF");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher RFCF");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher RFCF");

		    $ct = "UKEDCEUUKAEDEKECEBUPZBDBPKPCADZKUCDEPPUBECPZEDAEUUKBDCEPEEAAZZEEDDPKDB";
        $c->setmethod("RLCF");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher RLCF");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher RLCF");

		    $ct = "YXZUKEVZYUUKXZWEKEWYWUPZXVYPKPXYZZKUWZXPPUYVZPZEWYXUUKZVVEPEZYYZZEYWPK";
        $c->setmethod("CLRL");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher CLRL");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher CLRL");

		    $ct = "YXZQFAVZYQQFXZWAFAWYWQLVXVYLFLXYZVFQWZXLLQYVZLVAWYXQQFZVVALAZYYVVAYWLF";
        $c->setmethod("CLRF");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher CLRF");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher CLRF");

		    $ct = "DCEQFAAEDQQFCEBAFABDBQLVCADLFLCDEVFQBECLLQDAELVABDCQQFEAAALAEDDVVADBLF";
        $c->setmethod("CFRF");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher CFRF");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher CFRF");

		    $ct = "DCEAEUKEUUDCEBBKEKEUDBCADPZPKPCDEBEZKUPPCDAEBUPZEUDCEAAUKEPEEDDDBZZEPK";
        $c->setmethod("CFRL");
        $c->setperiod(5);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding colloncipher CFRL n=5");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding colloncipher CFRL n=5");

    }
}

?>
