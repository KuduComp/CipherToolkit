<?php

namespace cipher;

// Base31 coding of geocaching.com
// Encode codes id to gc codes
// Decode codes gc codes to id

class gcidcode {
	
    protected function gccode2gcid ($gc) {

		if (strtoupper(substr($gc,0,2)) == "GC") $gc = substr($gc,2);
		$id = 0;

		if ((strlen($gc) >= 1) && (strlen($gc) <= 4)) {

			// Base 16 hexadecimal all caches before GC1000
			$id = base_convert ($gc, 16, 10);
			return intval($id);

		} elseif ((strlen($gc) >= 5) && (strlen($gc) <= 6)) {

			// Base 31 all caches after GCFFFF
			$base31 = "0123456789ABCDEFGHJKMNPQRTVWXYZ";
			$base = 1;
			$id = 0;
			for ($i = strlen($gc)-1; $i>=0; $i--) {
				$id += $base * stripos($base31, $gc[$i]);
				$base *= 31;
				// echo $id, "\n";
			}
			// Minus 411120 (16^4 - 16*31^3)
			$id -= 411120;

		} else
			return 0;

		return $id;
	}

	protected function gcid2gccode ($id) {

		// Base 16 or base 31?
		if ($id <= 65536) {
			$code = strtoupper(base_convert ($id, 10, 16));
		} else {
			$base31 = "0123456789ABCDEFGHJKMNPQRTVWXYZ";
			$code = "";
			$id += 411120;
			while ($id >= 31) {
				$r = $id % 31;
				$code = $base31[$r] . $code;
				$id = intdiv ($id, 31);
			}
			$code = $base31[$id] . $code;
		}
		return "GC" . $code;
	}
    
	public function encode ($msg) {
		
		// Split into words
        preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
	    $s = "";
        
        // Process each word
		foreach ($matches[0] as $m) {
		    $s = $s . $this->gcid2gccode ((integer) $m) . " ";
		}
		return substr($s, 0, -1);
	}
	
    public function decode($msg) {
    		
		// Split into words
        preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
	    $s = "";
        
        // Process each word
		foreach ($matches[0] as $m) {
		    $s = $s . $this->gccode2gcid ($m) . " ";
		}
		return substr($s, 0, -1);
	}
    
        
    
} // class gcidcode

?>
