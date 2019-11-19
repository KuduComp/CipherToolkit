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

    function encodecolumnartransposition ($msg, $key) {
    
        $ncol = sizeof($key);
        $msglen = strlen($msg);
        $nrow = ceil ($msglen / $ncol);
        $nlongcol = $msglen % $ncol;        
        $row = 0;
        $col = 0;
        $table = array();
    
        // Write message row after row in array table
        for ($i = 0; $i < $msglen; $i++) {
        	$table[$col][$row] = $msg[$i];
        	if ($col < ($ncol-1)) 
        		$col++;
        	else if ($i < (strlen($msg)-1)) {
        		$col = 0;
        		$row++;
        	}
        }
    
        // Wrtie output column after colum in array table, taking into account order of key
        $s = "";
        for ($i = 0; $i < $ncol; $i++)
            echo $i,"\t", $nrow,"\t", $nlongcol, "\n";
        	for ($j = 0; $j < ($nrow - ($i > $nlongcol)); $j++) {
        		$s .= $table[$key[$i]][$j];
        		if return $s;
    }

	function decodecolumnartransposition ($msg = "", $key) {

	    $ncol = sizeof($key);
	    $msglen = strlen($msg);
	    $nrow = ceil ($msglen / $ncol);
        $nlongcol = $msglen % $ncol;
	    $col = 0;
	    $table = array();

	    // Write message column after column in array table
	    $idx = 0;
	    for ($i = 0; ($i < $ncol) && ($idx < $msglen); $i++) {
    		$collen = $nrow + ($nlongcol < $i);
    		for ($j = 0; ($j < $collen) && ($idx < $msglen); $j++) {
    		    $table[$key[$i]][$j] = $msg[$idx];
    		    $idx++;
    		}
	    }

	    // Write output column after colum in array table, taking into account order of key
	    $s = "";
	    for ($i = 0; ($i < $ncol) && (strlen($s) < $msglen); $i++)
	    	for ($j = 0; ($j < $nrow) && (strlen($s) < $msglen); $j++)
			    $s .= $table[$key[$i]][$j];

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

	

$msg="thequickbrownfoxjumpsoverthelazydog";
$key=array (2, 1, 0);

$res = encodecolumnartransposition ($msg, $key);
echo $res, "\n\n";
$res = decodecolumnartransposition ($msg, $key);
echo $res, "\n\n";

?>
