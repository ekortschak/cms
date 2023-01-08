<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to convert text to Hebrew names
e.g. am 2. Tag des 1. Monats => am 2. Abib

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/hebMonths.php");

$obj = new hebMonths();
$txt = $obj->conv($txt);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class hebMonths {
	private $dat = array();

function __construct() {
	$ini = new ini("files/hebMonths.ini");
	$this->dat = $ini->getValues("data");
}

// ***********************************************************
// methods
// ***********************************************************
public function conv($text) {
	$txt = $text;

	for ($i = 1; $i < 13; $i++) {
		$mon = $this->dat[$i];
		$txt = STR::replace($txt, "Tag des $i. Monats", $mon);
		$txt = STR::replace($txt, "$i. Monats", $mon);
		$txt = STR::replace($txt, "$i. Monat", $mon);
	}
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
