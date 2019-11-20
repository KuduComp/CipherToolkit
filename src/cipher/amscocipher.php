<?php


class amscocipher extends cipher {

	protected $numkey;
	protected $numkeymap;

	function __construct ($alphabet, $numkey = 0) {
		parent::__construct ($alphabet);
		$this-setnumkey ($numkey);
	}

	function setnumkey ($numkey) {
		$this->numkey = $numkey;
		$tmparr = str_split(strval($numkey));
		$numkeymap = array();
		foreach ($tmparr as $t) $numkeymap[] = intval($t);
	}

    	function getnumkey () { return $this->numkey; }

	    function encode ($msg = "") {
			// Remove everything that is not part of the alphabet
			// Write message in 1,2,1,2,... across columns
			// Print column after column using map
	    }

	    function decode ($msg = "") {
	      // Determine if column starts with 1 or 2 characters
	      // Fill column after column using map
	    }


}

?>
