<?php

use PHPUnit\Framework\TestCase;
use cipher\cadenuscipher;
use const \cipher\UPPER_ALPHABET;

//All test files must be named *Test.php (case sensitive T)

class CadenusTest extends TestCase
{
    public function testCadenus()
    {
        // Test caesar
        $pt = "aseverelimitationontheusefulnessofthecadenusisthateverymessagemustbeamultipleoftwentyfiveletterslong";
        $ct = "systretomtattlusoatleeesfiyheasdfnmschbhneuvsnpmtofarenuseieeieltarlmentieetogevesitfaisltngeeuvowul";
        $c = new cadenuscipher(UPPER_ALPHABET, "EASY");
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding cadenuscipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding cadenuscipher");
                 
    }
}
?>
