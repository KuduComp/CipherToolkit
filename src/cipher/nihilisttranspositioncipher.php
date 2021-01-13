<?php

  namespace cipher;

  // Dummy cipher for testing no encoding / decoding implemented
  class nihilisttranspositioncipher extends cipher {

    protected $key = "";
    protected $keymap;
    protected $readrow;  // If true output is row by row, if false column by column

    public function __construct ($alphabet, $key, $readrow = TRUE) {
      parent::__construct($alphabet);
      $this->setkey($key);
      $this->readrow = $readrow;
    }

    public function setkey ($key) {
      $this->key = $key;
      $this->size = strlen($key);
      $this->keymap = $this->createtranspositionkey($key);
    }

    public function getkey () { return $this->key; }
    public function setreadrow ($readrow = TRUE) { $this->readrow = $readrow; }
    public function getreadrow () { return $this->readrow; }

    public function encode ($msg) {
       // Append message to fill square
      for ($i = 0; $i < ($this->size**2 - strlen($msg)); $i++) $msg .= 'X';
      return $this->encodenihilisttransposition($msg, $this->keymap, $this->readrow);
    }

    public function decode ($msg) {
      return $this->decodenihilisttransposition($msg, $this->keymap, $this->readrow);
    }

  } // nihilisttranspositioncipher
?>
