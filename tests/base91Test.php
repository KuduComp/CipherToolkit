<?php

use PHPUnit\Framework\TestCase;
use cipher\base91code;

class Base91Test extends TestCase
{
    public function testBase91()
    {
        // Test basE91
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG";
		$ct = "nX2cA8sSVN!ZX]xb}q+0~7#B87ifyZ7d>OTdr#qY{6j";
        
        $c = new base91code();
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding base91code");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding base91code");
                 
    }
}

?>
