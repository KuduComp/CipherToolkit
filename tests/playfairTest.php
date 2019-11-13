<?php

use PHPUnit\Framework\TestCase;
use cipher\playfaircipher;

//

class PlayfairTest extends TestCase {

    public function testPlayfair()
    {
        $c = new playfaircipher (\cipher\UPPER_ALPHABET_REDUCED,"PLAYFAIREXAMPLE");
		$res = $c->encode ("HIDETHEGOLDINTHETREESTUMP");
        $this->assertEquals("BMODZBXDNABEKUDMUIXMMOVUIF",$res, "Error encoding playfair");
        $res = $c->decode ($res);
        $this->assertEquals("HIDETHEGOLDINTHETRXEESTUMP",$res, "Error decoding ADFGX");
    }
}
