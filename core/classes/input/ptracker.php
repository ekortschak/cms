<?php
/* ***********************************************************
// INFO
// ***********************************************************
serves as temporary storage for selectors and confirms
* watches their post vars
* determines if any action is required prior to display

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/ptracker.php");

$ptk = new ptracker();
$ptk->watch("cnf.act", true);

if ($ptk->get("sel_name")) {
	// do whatever needs to be done
}
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ptracker extends objects {
	private $lock = true;

function __construct() {
	$this->register();

	foreach ($_POST as $key => $val) {
		$this->hold($key, $val);
	}
}

// ***********************************************************
// methods
// ***********************************************************
public function watch($key = "cnf.act", $val = true) {
	$chk = $this->recall($key, NV); if ($chk === NV) return false;
	$this->lock = ($chk != $val);
	return (! $this->lock);
}

public function get($key, $default = false) {
	if ($this->lock) return false;

	$out = $this->recall($key, NV);
	$xxx = $this->forget();

	if ($out !== NV) return $out;
	return $default;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
