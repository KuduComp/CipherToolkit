<?php

/**
*
*
*/

namespace cipher;

class baseconvertor {

  protected $basemin = 2;
  protected $basemax = 32;
  protected $basestr = "0123456789abcdefhijklmnopqrstuvwxyz";
  protected $fromstr;
  protected $tostr;

  public function __construct ($fromstr ="", $tostr="") {
    $this->setcharacters($fromstr, $tostr);
  }

  public function setcharacters ($fromstr = "", $tostr = "") {
    $this->fromstr = $fromstr;
    $this->tostr = $tostr;
  }

  public function getcharacters() { return [$this->fromstr, $this->tostr]; }

  protected function base_convert2 ($input, $basefrom, $baseto, $fromstr, $tostr) {

    if (($basefrom < $this->basemin) || ($basefrom > $this->basemax)) return "Base from too small or too big";
    if (($baseto < $this->basemin) || ($baseto > $this->basemax)) return "Base to too small or too big";

    if ($fromstr !== "") {
      $inparr = [];
      for ($i = 0; $i < strlen($input); $i++)
        $inparr[$i] = $this->basestr[strpos($fromstr, $input[$i])];
      $input = implode("", $inparr);
    }

    $output = base_convert($input, $basefrom, $baseto);

    if ($tostr !== "") {
      $outparr = [];
      for ($i = 0; $i < strlen($output); $i++)
        $outparr[$i] = $tostr[strpos($this->basestr, $output[$i])];
      $output = implode("", $outparr);
    }
    return $output;
  }

  public function encode ($msg = "", $from = 10, $to = 10) {
    preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
    $s = "";

    // Process each word
    foreach ($matches[0] as $m) {
      $s .= $this->base_convert2 ($m, $from, $to, $this->fromstr, $this->tostr) . " ";
    }
    return substr($s, 0, -1);
  }

  public function decode ($msg = "", $from = 10, $to = 10) {
    preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
    $s = "";

    // Process each word
    foreach ($matches[0] as $m) {
      $s .= $this->base_convert2 ($m, $to, $from, $this->tostr, $this->fromstr) . " ";
    }
    return substr($s, 0, -1);
  }

} // class baseconvertor
