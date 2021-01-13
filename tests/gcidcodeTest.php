<?php
use PHPUnit\Framework\TestCase;
use cipher\gcidcode;
class GcidcodeTest extends TestCase
{
    public function testGcidcode()
    {
        // Test shadokcipher
		$pt = "4360405 512401 65535";
        $ct = "GC55555 GC10000 GCFFFF";

        $c = new gcidcode();
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding gcidcode");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding gcidcode");
                 
    }
}
?>
