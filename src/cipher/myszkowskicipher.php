<?php

namespace cipher;

class myszkowskicipher extends cipher {

    protected $key;

	public function __construct ($alphabet, $key) {
		parent::__construct ($alphabet);
		$this->setkey ($key);
	}

	public function setkey ($key) {
					$this->key = $key;
	}

	public function getkey () { return $this->key; }

	function encodemyszkowskitransposition ($msg, $key) {

		$n1 = 0;  // Aantal aggregated columns
		$na = []; // aggregated column contains number of columns
		$na[$n1] = 1;
		$colkey = $this->createtranspositionkey ($key);

		for ($i = 0; $i < (sizeof($colkey) -1); $i++) {
			if ($key[array_search ($i, $colkey)] == $key[array_search($i+1,$colkey)])
				$na[$n1]++;
			else {
				$n1++; $na[$n1] = 1;
			}
		}
	  

		$s = "";
		$nrow = (integer) ceil(strlen($msg) / sizeof($colkey));
		$colcnt = 0;
		$nlongcol = strlen($msg) % sizeof($colkey);

		// Put msg in table
		for ($i = 0; $i < strlen($msg); $i++)
			$table[intdiv ($i, sizeof($colkey))][ $i % sizeof($colkey)] = $msg[$i];

		// for each aggregated column
		for ($i = 0; $i < sizeof($na); $i++) {

			// Print all rows for the aggregated column
			for ($row = 0; $row < $nrow; $row++) {

				// Print each column in the aggregated column
				for ($c = 0; $c < $na[$i]; $c++) {
					$col = array_search($colcnt + $c, $colkey);
					if (($col >= $nlongcol) && ($nlongcol != 0) && ($row == $nrow-1)) continue;
					$s .= $table [$row][$col];
				}
			}
			$colcnt += $na[$i];
		}
		return $s;
	}

	function decodemyszkowskitransposition ($msg, $key) {

		$n1 = 0;  // Aantal aggregated columns
		$na = []; // aggregated column contains number of columns
		$na[$n1] = 1;
		$colkey = $this->createtranspositionkey ($key);

		for ($i = 0; $i < (sizeof($colkey) -1); $i++) {
			if ($key[array_search ($i, $colkey)] == $key[array_search($i+1,$colkey)])
				$na[$n1]++;
			else {
				$n1++; $na[$n1] = 1;
			}
		}

		$s = "";
		$idx = 0;
		$colcnt = 0;
		$nrow = (integer) ceil(strlen($msg) / sizeof($colkey));
		$nlongcol = strlen($msg) % sizeof($colkey);

		// For each aggregated column
		for ($i = 0; $i < sizeof($na); $i++) {

			// Print all rows for the aggregated column
			for ($row = 0; $row < $nrow; $row++) {

				// Print each column in the aggregated column
				for ($c = 0; $c < $na[$i]; $c++) {
					$col = array_search ($c + $colcnt, $colkey);
					if (($col > $nlongcol-1) && ($nlongcol != 0) && ($row == $nrow - 1)) continue;
					$table[$row][$col] = $msg[$idx++];
				}
			}
			$colcnt += $na[$i];
		}

		$s = "";
		for ($row = 0; $row < $nrow; $row++) {
			(($row == $nrow - 1)  && ($nlongcol != 0)) ? $collen = $nlongcol : $collen = sizeof($colkey);
			for ($col = 0; $col < $collen; $col++)  {
					$s .= $table[$row][$col];
				}
			}
		return $s;
	}
	
	public function encode ($msg) {
		return $this->encodemyszkowskitransposition ($msg, $this->key);
	}

    public function decode ($msg) {
		return $this->decodemyszkowskitransposition ($msg, $this->key);
    }



} // class

?>

 