<?php

namespace cipher;

class jeffersonwheelcipher {

    protected $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
    protected $cylsize = 26;
    protected $offset = 1;
    protected $cylinders = array (
                        "ABCEIGDJFVUYMHTQKZOLRXSPWN", "ACDEHFIJKTLMOUVYGZNPQXRWSB",
                        "ADKOMJUBGEPHSCZINXFYQRTVWL", "AEDCBIFGJHLKMRUOQVPTNWYXZS",
                        "AFNQUKDOPITJBRHCYSLWEMZVXG", "AGPOCIXLURNDYZHWBJSQFKVMET",
                        "AHXJEZBNIKPVROGSYDULCFMQTW", "AIHPJOBWKCVFZLQERYNSUMGTDX",
                        "AJDSKQOIVTZEFHGYUNLPMBXWCR", "AKELBDFJGHONMTPRQSVZUXYWIC",
                        "ALTMSXVQPNOHUWDIZYCGKRFBEJ", "AMNFLHQGCUJTBYPZKXISRDVEWO",
                        "ANCJILDHBMKGXUZTSWQYVORPFE", "AODWPKJVIUQHZCTXBLEGNYRSMF",
                        "APBVHIYKSGUENTCXOWFQDRLJZM", "AQJNUBTGIMWZRVLXCSHDEOKFPY",
                        "ARMYOFTHEUSZJXDPCWGQIBKLNV", "ASDMCNEQBOZPLGVJRKYTFUIWXH",
                        "ATOJYLFXNGWHVCMIRBSEKUPDZQ", "AUTRZXQLYIOVBPESNHJWMDGFCK",
                        "AVNKHRGOXEYBFSJMUDQCLZWTIP", "AWVSFDLIEBHKNRJQZGMXPUCOTY",
                        "AXKWREVDTUFOYHMLSIQNJCPGBZ", "AYJPXMVKBQWUGLOSTECHNZFRID",
                        "AZDNBUHYFWJLVGRCQMPSOEXTKI");
    
    function setcylinders ($cylinders) { $this->cylinders = $cylinders; }
    function getcylinders () { return $this->cylinders; }
    function setoffset ($offset) { $this->offset = $offset; }
    function getoffset () { return $this->offset; }
    
    function encode ($msg = "") {

        $s = "";
        for ($i = 0; $i < strlen($msg); $i++) {
            $cyl = $i % sizeof($this->cylinders);
            $pos = stripos ($this->cylinders[$cyl], $msg[$i]);
            if ($pos === FALSE) return $s .= " Illegal character found: " . $msg[$i];
            $s .= $this->cylinders[$cyl][($pos + $this->offset) % $this->cylsize ];
        }
        return $s;
    }
    
    function decode ($msg = "") {

        $s = "";
        for ($i = 0; $i < strlen($msg); $i++) {
            $cyl = $i % sizeof($this->cylinders);
            $pos = stripos ($this->cylinders[$cyl], $msg[$i]);
            if ($pos === FALSE) return $s .= " Illegal character found: " . $msg[$i];
            $s .= $this->cylinders[$cyl][($pos + $this->cylsize - $this->offset) % $this->cylsize];
        }
        return $s;
    } 

} // Class jeffersonwheelcipher