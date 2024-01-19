<?php

namespace cipher\polybiuscipher;

class ADFGVXcipher extends \cipher\polybiuscipher {

    protected $colkey = "";
    protected $keylen = 0;
    protected $permkey = [];

    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key, $colkey) {
        if (strlen($alphabet) == 25) {
            parent::__construct ($alphabet, $key, "ADFGX", "ADFGX");
        } elseif (strlen($alphabet) == 36) {
            parent::__construct ($alphabet, $key, "ADFGVX", "ADFGVX");
        }
        $this->setcolkey($colkey);
    }

    public function setcolkey ($colkey) {
        $this->colkey = $colkey;
        $this->keylen = strlen($colkey);

        // Code to generate permkey  col x -> col y, start numbering at 0
        // E.g. PILOTEN  column 0->5 , 1->1, 2->2, 3->4, 4->6, 5->0, 6->3

        $tmparr = [];
        for ($i = 0; $i<$this->keylen; $i++) { $tmparr[$i][0] = $colkey[$i]; $tmparr[$i][1] = $i; }
        sort ($tmparr);
        $this->permkey = [];
        for ($i = 0; $i<$this->keylen; $i++) $this->permkey[$tmparr[$i][1]] = $i;
    }

    public function getcolkey () { return $this->colkey; }
    public function encode ($msg) {

        // Create pairs
        $msg = parent::encode($msg);

        // Remove separators
        $s = ""; for ($i=0; $i<strlen($msg); $i++) if ($msg[$i] != $this->sep) $s .= $msg[$i];
        $msg = $s;

        // Fill columns starting at 0
        for ($i = 0; $i<$this->keylen; $i++) $tbl[$i] = "";
        for ($i = 0; $i<strlen($msg); $i++) {
            $col = ($i % $this->keylen);
            $tbl[$col] .= $msg[$i];
        }

        // Create string by printing column after column
        $s = "";
        for ($i = 0; $i<$this->keylen; $i++) $s .= $tbl[array_search((string) $i, $this->permkey)];
        return $s;
    }

    public function decode ($msg) {

        // Create empty table
        $tbl = [];

        // Fill the table
        // This should be done differently
        $s = $msg;
        for ($i = 0; $i<$this->keylen; $i++) {
            $collen = intdiv(strlen($msg), $this->keylen);
            $col = array_search((string) $i, $this->permkey);
            if ($col < (strlen($msg) % $this->keylen)) $collen++;
            $tbl[$col] = substr($s, 0, $collen);
            $s = substr($s, $collen);
        }

        // Create the new string
        // Create string by printing column after column
        $s = "";
        for ($i = 0; $i < strlen($msg); $i++) {
            $s .= $tbl[$i % $this->keylen][intdiv($i, $this->keylen)];
        }

        //Decode polybius
        return parent::decode ($s);
    }
} // End of class ADFGVX cipher

?>
