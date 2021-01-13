<?php

namespace cipher;

/**
 * Base16 encoder and decoder
 *
 * RFC 4648 compliant
 * @link http://www.ietf.org/rfc/rfc4648.txt
 *
 * @author Aernout Koolen
 * @license MIT License see LICENSE file
 */

class Base16
{
    /**
     * Alphabet for encoding and decoding base32
     *
     * @var array
     */
    private static $alphabet = '0123456789ABCDEF';

    /**
     * Encodes into base32
     *
     * @param string $string Clear text string
     * @return string Base16 encoded string
     */
    public static function encode($string)
    {
        // Start with an empty base16
        $base16String = '';

        // Encode in base16
        for ($i=0; $i < strlen($string); $i++) {

            $c = ord($string[$i]);

            // Take the first four bits
            $idx = ($c >> 4);
            $base16String .= self::$alphabet[$idx];
            // Take the last four bits
            $idx = $c & 0x0F;
            $base16String .= self::$alphabet[$idx];
        }

        return $base16String;
    }

    /**
     * Decodes base32
     *
     * @param string  $base16String Base16 encoded string
     * @return string Clear text string
     */
    public static function decode($base16String)
    {
        // Only work in upper cases
        $base16String = strtoupper($base16String);

        // Remove anything that is not base32 alphabet
        $pattern = '/[^A-F0-9]/';
        $base16String = preg_replace($pattern, '', $base16String);

        // Start with an empty string
        $s = "";

        // Scan the string 2 characters at a time
        for ($i = 0; $i < strlen($base16String); $i += 2) {

            // First character is the lefmost 4 bits
            $i1 = strpos(self::$alphabet, $base16String[$i]);
            // Second character is the rightmost 4 bits
            $i2 = strpos(self::$alphabet, $base16String[$i+1]);

            // Create the byte and add to the strings
            $s .= chr(($i1 << 4) | $i2);
        }

        return $s;
    }
}

?>
