<?php

use PHPUnit\Framework\TestCase;
use cipher\shadokcipher;

class ShadokTest extends TestCase
{
    public function testCondi()
    {
        // Test shadokcipher
        $pt = "1234565432 1234 121221";
		    $ct = "BUGAZOBUZOBUBUBUMEUMEUZOBUGAMEUZOGA BUGAMEUBUGAZO BUMEUBUZOBUZOGABUBU";
        $c = new shadokcipher();
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding shadokcipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding shadokcipher");
                 
    }
}
?>
