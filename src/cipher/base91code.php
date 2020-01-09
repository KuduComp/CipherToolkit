<?php

namespace cipher;

// Base91 is an alternative to encoding similar to base64 or uuencode
// Copyright (c) 2005-2006 Joachim Henke
// Code used from http://base91.sourceforge.net/

class base91code {
	
    protected $b91_enctab = array(
	    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
	    'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
	    'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '#', '$',
	    '%', '&', '(', ')', '*', '+', ',', '.', '/', ':', ';', '<', '=',
	    '>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~', '"');
    
    function decode($msg) {
        
        $b91_dectab = array_flip($this->$b91_enctab);
        $l = strlen($msg);
        $v = -1;
        for ($i = 0; $i < $l; ++$i) {
            $c = $b91_dectab[$msg{$i}];
            if (!isset($c))
                continue;
            if ($v < 0)
                $v = $c;
            else {
                $v += $c * 91;
                $b |= $v << $n;
                $n += ($v & 8191) > 88 ? 13 : 14;
                do {
                    $o .= chr($b & 255);
                    $b >>= 8;
                    $n -= 8;
                } while ($n > 7);
                $v = -1;
            }
        }
        if ($v + 1)
            $o .= chr(($b | $v << $n) & 255);
        return $o;
    }

    function encode($msg) {
        $l = strlen($msg);
	    $n = 0;
        for ($i = 0; $i < $l; ++$i) {
            $b |= ord($msg{$i}) << $n;
            $n += 8;
            if ($n > 13) {
                $v = $b & 8191;
                if ($v > 88) {
                    $b >>= 13;
                    $n -= 13;
                } else {
                    $v = $b & 16383;
                    $b >>= 14;
                    $n -= 14;
                }
                $o .= $this->b91_enctab[$v % 91] . $this->b91_enctab[$v / 91];
            }
        }
        if ($n) {
            $o .= $this->b91_enctab[$b % 91];
            if ($n > 7 || $b > 90)
                $o .= $this->b91_enctab[$b / 91];
        }
        return $o;
    }
    
} // class base91

?>
