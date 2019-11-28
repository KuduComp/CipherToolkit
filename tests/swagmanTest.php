<?php

use PHPUnit\Framework\TestCase;
use cipher\swagmancipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class SwagmanTest extends TestCase
{
    public function testSwagman()
    {
        // Test caesar
        $pt = "dontbeafraidtotakeabigleapifoneisindicatedyoucannotcrossariverorachasmintwosmalljumps";
        $ct = "endsc morda niboi sictn astgb ltewa oaree fsaid vpyrm oeaia fuilr ldoco tjnra aenou ncmit soaph skati";
        $c = new swagmancipher();
		$c->setkeysquare ( array( 1 => array(3,2,1,4,5), 2 => array(1,5,3,2,4), 3 => array (2,4,5,3,1),
								  4 => array(5,3,4,1,2), 5 => array(4,1,2,5,3)) );        
								  
		$res = $c->encode ($pt);
		$c->setblock(5);
		$c->setsep(" ");
		$res = $c->formatoutput($res);
        $this->assertEquals($ct,$res, "Error encoding swagmancipher");
        $res = $c->cleaninput ($ct);
        $res = $c->decode ($res);
		$this->assertEquals($pt,$res, "Error decoding swagmancipher");
                 
    }
}

?>
