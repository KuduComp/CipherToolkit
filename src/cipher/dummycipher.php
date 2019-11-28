<?php

namespace cipher;

// Dummy cipher for testing no encoding / decoding implemented
class dummycipher extends cipher {
    public function encode ($text) { return $text; }
    public function decode ($text) { return $text; }
}

?>