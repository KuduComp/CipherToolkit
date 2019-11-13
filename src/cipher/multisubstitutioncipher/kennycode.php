<?php 

namespace cipher\multisubstitutioncipher;

class kennycode extends \cipher\multisubstitutioncipher {
    
    protected $kennycodelen = 3;
    protected $kennyvalidcodes = "mpf";
    protected $kennycode = array('mmm' => 'a', 'mmp' => 'b', 'mmf' => 'c', 'mpm' => 'd',
        'mpp' => 'e', 'mpf' => 'f', 'mfm' => 'g', 'mfp' => 'h',
        'mff' => 'i', 'pmm' => 'j', 'pmp' => 'k', 'pmf' => 'l',
        'ppm' => 'm', 'ppp' => 'n', 'ppf' => 'o', 'pfm' => 'p',
        'pfp' => 'q', 'pff' => 'r', 'fmm' => 's', 'fmp' => 't',
        'fmf' => 'u', 'fpm' => 'v', 'fpp' => 'w', 'fpf' => 'x',
        'ffm' => 'y', 'ffp' => 'z');
    
    public function __Construct() {
        parent::__Construct ($this->kennycodelen, $this->kennyvalidcodes, $this->kennycode);
    }
    
} // kennycode

?>