<?php

namespace cipher;

// Zebra is a substitution table used by East German secret services
// It was combined with a one time pad to make it secure

class zebracipher extends cipher {
    
  protected $letsnums = "89";
  protected $table = [
    "A"  => "0",      "E" =>  "1",        "I"  => "2",      "N" =>  "3",
    "Ä"  => "40",     "AU" => "41",       "B"  => "42",     "BE" => "43",
    "C"  => "44",     "CH" => "45",       "D"  => "46",     "DE" => "47",
    "DER"=> "48",     "ER" => "49",       "F"  => "50",     "G" =>  "51",
    "GE" => "52",     "H" =>  "53",       "J"  => "54",     "K" =>  "55",
    "L"  => "56",     "M" =>  "57",       "O"  => "58",     "Ö" =>  "59",
    "P"  => "60",     "Q" =>  "61",       "R"  => "62",     "RE" => "63",
    "S"  => "64",     "SCH" => "65",      "SE" => "66",     "ST" => "67",
    "SU" => "68",     "T" =>  "69",       "TE" => "70",     "U" =>  "71",
    "Ü"  => "72",     "UNG" => "73",      "V"  => "74",     "W" =>  "75",
    "X"  => "76",     "Y" =>  "77",       "Z"  => "78",     "ZE" => "79",
    "."  => "80",     ":" =>  "81",       ","  => "82",     "-" =>  "83",
    "/"  => "84",     "(" =>  "85",       " "  => "86",     ")" =>  "87",
    '"'  => "88",     "0"  => "000",      "1" =>  "111",
    "2"  => "222",    "3" =>  "333",      "4"  => "444",    "5" =>  "555",
    "6"  => "666",    "7" =>  "777",      "8"  => "888",    "9" =>  "999"
  ];
      
  function encode ($t) {
      
    $t = strtoupper($t);
    preg_match_all('(DER|SCH|UNG|AU|BE|CH|DE|ER|GE|RE|SE|ST|SU|TE|ZE|A|E|I|N|Ä|B|C|D|F|G|H|J|K|L|M|O|Ö|P|Q|R|S|T|U|Ü|V|W|X|Y|Z|0|1|2|3|4|5|6|7|8|9|.|:|,|-|\/|\(|\)|")', $t, $chars);
        
    $s = "";
    $nums = false;
    
    foreach ($chars[0] as $c) {
          
      if (array_key_exists($c, $this->table)) {
          
        // Check if we need to switch lets or nums
        if ($nums && strpos("EINÄAUBECCHDERFGEHJKLMOÖPQRESCHSESTSUNGTEÜVWXYZE", $c) !== false) {
          $nums = !$nums;
          $s .= $this->letsnums;
        }
        if (!$nums && strpos('.:,-/()"0123456789', $c) !== false) {
          $nums = !$nums;
          $s .= $this->letsnums;
        }
        $s .= $this->table[$c];
          
      } else {
        // Unknown char
      }
    }
    return $s; 
  }
  
  function decode ($t) {
      
    preg_match_all('((000|111|222|333|444|555|666|777|888|999)|[4-9][0-9]|[0-3,9])', $t, $codes);
    
    $s = "";
    $nums = false;
    
    foreach ($codes[0] as $c) {
        
      // Nums letters
      if ($c == $this->letsnums) $nums = !$nums;

      // Space works in both modes
      if ($c == "86") {
        $s .= " ";
        continue;
      }

      // Check code is valid, if not skip
      if (array_search($c, $this->table) === false) continue;
      
      if ($nums) {
          $s .= array_search($c, array_slice($this->table, 44));
      } else {
        switch ($c) {
          // Triple occurances parsed as numbers
          case "111" : 
            $s .= "EEE"; break;
          case "222" : 
            $s .= "III"; break;
          case "333" : 
            $s .= "NNN"; break;
          case "000" : 
            // "0" also false into this trap
            if ($c === "000") $s.= "AAA";
          default :
            $s .= array_search($c, $this->table);
        }
      }
    }
    return $s;
  }

} // End of zebracipher

?>
