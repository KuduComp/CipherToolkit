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

	function encodecolumnartransposition ($msg = "", $key) {

	    $ncol = sizeof($key);
	    $row = 0;
	    $col = 0;
	    $table = array();

	    // Write message row after row in array table
	    for ($i = 0; $i < strlen($msg); $i++) {
		$table[$col][$row] = $msg[$i];
		if ($col < ($ncol-1)) 
			$col++;
		else if ($i < (strlen($msg)-1)) {
			$col = 0;
			$row++;
		}
	    }

	    // Wrtie output column after colum in array table, taking into account order of key
	    $nrow = $row;
	    $s = "";
	    for ($i = 0; $i < $ncol; $i++)
		for ($j = 0; $j < $nrow; $j++)
			$s .= $table[$key[$i]][$j];

	    return $s;
	}

	function decodecolumnartransposition ($msg = "", $key) {

	    $ncol = sizeof($key);
	    $nrow = ceil (strlen($msg) / $ncol);
            $nshortcol = strlen($msg) % $ncol;
	    $col = 0;
	    $table = array();

	    // Write message column after column in array table
	    $idx = 0;
	    for ($i = 0; $i < $ncol; $i++) {
		$collen = $nrow + ($nshortcol < $i);
		for ($j = 0; $j < $collen; $j++) {
		    $table[$key[$col]][$row] = $msg[$idx];
		    $idx++;
		}
	    }

	    // Write output column after colum in array table, taking into account order of key
	    $nrow = $row;
	    $s = "";
	    for ($i = 0; $i < $ncol; $i++)
		for ($j = 0; $j < $nrow; $j++)
			$s .= $table[$i][$j];

	    return $s;
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
