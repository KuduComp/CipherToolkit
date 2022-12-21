<?php

use PHPUnit\Framework\TestCase;
use cipher\rot123cipher;

//All test files must be named *Test.php (case sensitive T)

class ROT123Test extends TestCase
{
    public function testROT123()
    {
        // Test caesar
        $c = new rot123cipher();
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("UJHUZOJSKBZIATDNAMFJNKSCQTIGOEEEKWP",$res, "Error encoding ROT123");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUXCKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding ROT123");
        
    }
}
?>
