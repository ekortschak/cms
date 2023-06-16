<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to remove spaces from common abbreviations

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/acro.php");

*/

ACR::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ACR {
	private static $lst = array();

static function init() {
	$ini = new ini("lookup/acro.ini");
	ACR::$lst = $ini->getValues("ref");
}

// ***********************************************************
// methods
// ***********************************************************
public static function clean($text) {
	$out = $text;

	foreach (ACR::$lst as $key => $val) {
		$fnd = STR::replace($key, ".", ". "); $fnd = trim($fnd);
		$out = STR::replace($out, $fnd, $key);
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
