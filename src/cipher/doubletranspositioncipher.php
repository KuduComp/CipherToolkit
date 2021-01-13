<?php

namespace cipher;

class doubletranspositioncipher extends cipher {

    protected $key1 = "";
    protected $key2 = "";
    protected $keylen1 = 0;
    protected $keylen2 = 0;
    protected $keymap1;
    protected $keymap2;

    function __construct ($alphabet  = UPPER_ALPHABET, $key1 = "", $key2 = "") {
        parent::__construct ($alphabet);
        $this->setkeys ($key1, $key2);
    }

    function setkeys ($key1, $key2) {
        $this->key1 = $key1;
        $this->key2 = $key2;
        $this->keylen1 = strlen($key1);
        $this->keylen2 = strlen($key2);
        $this->keymap1 = $this->createtranspositionkey ($key1);
        $this->keymap2 = $this->createtranspositionkey ($key2);
    }

    function getkeys () { return [$key1, $key2]; }

    function encode ($msg = "") {
        $res = $this->encodecolumnartransposition ($msg, $this->keymap1);
        return $this->encodecolumnartransposition ($res, $this->keymap2);
    }


    function decode ($msg = "") {
        $res = $this->decodecolumnartransposition ($msg, $this->keymap2);
        return $this->decodecolumnartransposition ($res, $this->keymap1);
    }
}

?>
