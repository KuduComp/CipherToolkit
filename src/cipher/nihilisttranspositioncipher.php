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
              
      public function encode ($text) { 
        // Checks
        if ($this->key == "") return "No key specified";
        if ($this->keymap == null) return "No key specified";
        if ($msg == "") return "Nothing to encode";

	      // Append message to fill square
        for ($i = 0; $i < ($this->size**2 - strlen($msg)); $i++) $msg .= 'X';
        
        return $this->nihilisttransposition($msg, $this->keymap, $this->readrow);
      }
      
      public function decode ($text) { 
        // Checks
        if ($this->key == "") return "No key specified";
        if ($this->keymap == null) return "No key specified";
        if ($msg == "") return "Nothing to encode";
        if (strlen($msg) != $this->size**2) return "Message length should be the square of the key";

        return $this->nihilisttransposition($msg, $this->keymap, $this->readrow); 
      }
      
  } // nihilisttranspositioncipher
?>
