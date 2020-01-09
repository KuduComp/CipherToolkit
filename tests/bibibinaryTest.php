<?php
use PHPUnit\Framework\TestCase;
use cipher\bibibinarycipher;
class BibibinaryTest extends TestCase
{
    public function testBibibinary()
    {
        // Test shadokcipher
        $pt = "1234565432 1234 121221";
		    $ct = "BOKAKABADIKAHIKO BODAHE HADAKAKOBA";
        $c = new bibibinarycipher();
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding bibibinarycipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding bibibinarycipher");
                 
    }
}
?>
