<?php

namespace cipher;

// Tapir was used by East German secret services. It is a simple
// substitution that was combined with a one time pad to make it safe

class tapircipher extends cipher {

  protected $table = [
    "A"  => "0",     "E"  => "1",    "I"  =>	"2",    "N"  => "3",
    "R"  =>	"4",     "B"  => "50",   "BE" => "51",    "C"  => "52",
    "CH" => "53",    "D"  => "54",   "DE" => "55",    "F"  => "56",
    "G"  => "57",    "GE" => "58",   "H"  => "59",    "J"  => "60",
    "K"  => "61",    "L"  => "62",   "M"  => "63",    "O"  => "64",
    "P"  => "67",    "Q"  => "68",   "S"  => "69",    "T"  => "70",
    "TE" => "71",    "U"  => "72",   "UN" => "73",    "V"  => "74",
    "W"  => "76",    "X"  => "77",   "Y"  => "78",    "Z"  => "79",
    "\n" => "80",    " "  => "83",   "."  => "89",    ":"  => "90",
    ","  => "91",    "-"  => "92",   "/"  => "93",    "("  => "94",
    ")"  => "95",    "+"  => "96",   "="  => "97",    '"'  => "98",
    "0"  => "00",    "1"  => "11",   "2"  => "22",    "3"  => "33",
    "4"  => "44",    "5"  => "55",   "6"  => "66",    "7"  => "77",
    "8"  => "88",    "9"  => "99"
  ];

  protected $tonums = "82";
  protected $tolets = "81";

  public function encode ($text) {

    $result = "";
    $nummode = false;
    $text = strtoupper($text);
    $regex = '(BE|CH|DE|GE|TE|UN|A|E|I|N|R|B|C|D|F|G|H|J|K|L|M|O|P|Q|S|T|U|V|W|X|Y|Z|0|1|2|3|4|5|6|7|8|9|\n| |.|:|,|-|\/|\(|\)|=|")';
    
    preg_match_all( $regex, $text, $chars);

    foreach ($chars[0] as $c) {

      if (array_key_exists($c, $this->table)) {

        // Known character
        // See if we need to switch between numbers and letters
        if ($nummode && (strpos ("ABCDEFGHIJKLMNOPQRSTUVWXYZBECHGETEUN", $c) !== false)) { 
          $result .= $this->tolets; 
          $nummode = false;
        }
        if (!$nummode && (strpos ('.:,-/()+="0123456789', $c) !== false)) {
          $result .= $this->tonums;
          $nummode = true;
        } 
        $result .= $this->table[$c];

      } else {
        // Unknown character
      }

    }

    return $result;

  }

  public function decode ($text) {

    $result = "";
    $nummode = false;
    $regex = "((00|11|22|33|44|55|66|77|88|99)|[5-9][0-9]|[0-4])";

    preg_match_all($regex, $text, $codes);

    // This doesn't work when not in nummode 00, 11, 22, 33 are double A E I N

    foreach ($codes[0] as $c) {

      if (array_search($c, $this->table) !== false) {

        // Key known
        if ($c == $this->tonums) $nummode = true;
        if ($c == $this->tolets) $nummode = false;

        // Space and carriage return work in both modes
        if ($c == "80" && $c == "83") 
          $result .= array_search($c, $this->table);
        elseif (!$nummode)
          // When in text mode 11, 22, 33 and 00 are parsed incorrectly
          switch ($c) {
            case "11" :
              $result .= "EE"; break;
            case "22" :
              $result .= "II"; break;
            case "33" :
              $result .= "NN"; break;
            case "00" : 
              // Strangely "0" also falls into this trap, fixed using ===
              if ($c === "00") {
                  $result .= "AA";
                  break;
              }
            default:
              $result .= array_search($c, $this->table);
          } 
        else 
          //Numbers mode, start search at 
          $result .= array_search($c, array_slice($this->table, 34));

      }
    }

    return $result;

  }

} // End of tapircode

?>