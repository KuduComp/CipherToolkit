<?php
use PHPUnit\Framework\TestCase;
use cipher\baseconvertor;
use const \cipher\UPPER_ALPHABET;

class BaseconvertorTest extends TestCase
{
    public function testBaseconvertor()
    {
        // Test baseconvertor
        $pt = "1234565432 1234 121221";
		    $ct = "4995f938 4d2 1d985";
        $c = new baseconvertor();
        $res = $c->encode ($pt, 10, 16);
        $this->assertEquals($ct,$res, "Error encoding baseconvertor");
        $res = $c->decode ($ct, 10, 16);
        $this->assertEquals($pt,$res, "Error decoding baseconvertor");

        $c->setcharacters ("ABCDEFGHIJ", "0123456789abcdef");
        $pt = "BCDEFGFEDC BCDE BCBCCB";
        $ct = "4995f938 4d2 1d985";

        $res = $c->encode ($pt, 10, 16);
        $this->assertEquals($ct, $res, "Error encoding baseconvertor with other characters");
        $res = $c->decode ($ct, 10, 16);
        $this->assertEquals($pt, $res, "Error decoding baseconvertor with other characters");
    }
}
?>
