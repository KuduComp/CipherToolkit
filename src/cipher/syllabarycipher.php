<?php

namespace cipher;

class syllabarycipher extends cipher {
    
    protected $tab = [
        "A",   "1",   "AL",  "AN",  "AND", "AR",  'ARE', "AS",  "AT",  "ATE",
        "ATI", "B",   "2",   "BE",  "C",   "3",   "CA",  "CE",  "CO",  "COM",
        "D",   "4",   "DA",  "DE",  "E",   "5",   "EA",  "ED",  "EN",  "ENT",
        "ER",  "ERE", "ERS", "ES",  "EST", "F",   "6",   "G",   "7",   "H",
        "8",   "HAS", "HE",  "I",   "9",   "IN",  "ING", "ION", "IS",  "IT",
        "IVE", "J",   "0",   "K",   "L",   "LA",  "LE",  "M",   "ME",  "N",
        "ND",  "NE",  "NT",  "O",   "OF",  "ON",  "OR",  "OU",  "P",   "Q",
        "R",   "RA",  "RE",  "RED", "RES", "RI",  "RO",  "S",   "SE",  "SH",
        "ST",  "STO", "T",   "TE",  "TED", "TER", "TH",  "THE", "THI", "THR",
        "TI",  "TO",  "U",   "V",   "VE",  "W",   "WE",  "X",   "Y",   "Z"
        ];
        
    protected $coord_rows;
    protected $coord_cols;
    protected $key = "";
    protected $keys = [];
    private $re = '/(AND|ARE|ATE|ATI|COM|ENT|ERE|ERS|EST|HAS|ION|ING|IVE|RED|RES|STO|TED|TER|THE|THI|THR|AL|AN|AR|AS|AT|BE|CA|CE|CO|DA|DE|EA|ED|EN|ER|ES|HE|IN|IS|IT|LA|LE|ME|ND|ND|NE|NT|OF|ON|OR|OU|RA|RE|RI|RO|SE|SH|ST|TE|TH|TI|TO|VE|WE|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|1|2|3|4|5|6|7|8|9|0)/mi';

    public function __construct ($alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", $key = "A", $coordrows = "0123456789", $coordcols = "0123456789") {
        parent::__construct ($alphabet);
        $this->setkey($key);
        $this->setcoordinates($coordrows, $coordcols);
    }

    public function setkey ($k = "A") {
    
        $this->key = $k;
        preg_match_all($this->re, $k, $matches, PREG_SET_ORDER, 0);
        $this->keys = [];
        foreach ($matches as $m) {
            // See if key is A - J and insert number if so
            array_push($this->keys, $m[0]);
            if (stripos("ABCDEFGHIJ", $m[0]) !== FALSE) {
                array_push($this->keys, "" . ((stripos("ABCDEFGHIJ", $m[0]) + 1) % 10));
            }
        }
        array_splice($this->keys, 9999999, 0, $this->tab);
        $this->keys = array_values(array_unique($this->keys));
    }

    public function getkey() { return $this->key; }
    public function setcoordinates($r = "0123456789", $c = "0123456789") { 
      $this->coord_rows = $r;
      $this->coord_cols = $c;
    }
    public function getcoordinates() { return [$this->coord_rows, $this->coord_cols]; }
    
    public function encode ($t) {
        
        // Parse the message
        $t = strtoupper($t);
        preg_match_all($this->re, $t, $matches, PREG_SET_ORDER, 0);

        // Print the entire match result
        $result = "";
        foreach ($matches as $m) {
            $idx = array_search($m[0], $this->keys);
            $result .= $this->coord_rows[intdiv($idx,10)] . $this->coord_cols[$idx % 10];
        }

        return $result; 
    }
    
    public function decode ($t) {

      $result = "";
      for ($i = 0; $i < strlen($t); $i += 2) {
        $r = strpos($this->coord_rows, $t[$i]);
        $c = strpos($this->coord_cols, $t[$i+1]);
        $result .= $this->keys[$r*10+$c];
      }

      return $result;
    }
}

?>