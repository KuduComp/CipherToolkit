<?php 

namespace cipher\multisubstitutioncipher;

class kennycode extends \cipher\multisubstitutioncipher {
    
    protected $kennycodelen = 3;
    protected $kennyvalidcodes = "mpf";
    protected $kennycode = array('a' => 'mmm', 'b' => 'mmp', 'c' => 'mmf', 'd' => 'mpm',
        'e' => 'mpp', 'f' => 'mpf', 'g' => 'mfm', 'h' => 'mfp',
        'i' => 'mff', 'j' => 'pmm', 'k' => 'pmp', 'l' => 'pmf',
        'm' => 'ppm', 'n' => 'ppp', 'o' => 'ppf', 'p' => 'pfm',
        'q' => 'pfp', 'r' => 'pff', 's' => 'fmm', 't' => 'fmp',
        'u' => 'fmf', 'v' => 'fpm', 'w' => 'fpp', 'x' => 'fpf',
        'y' => 'ffm', 'z' => 'ffp');
    
    public function __Construct() {
        parent::__Construct ($this->kennycodelen, $this->kennyvalidcodes, $this->kennycode);
    }
    
} // kennycode

?>