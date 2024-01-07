<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to protect substrings in any text such as
* code fragments
* comments

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/strProtect.php");

$obj = new strProtect();
$txt = $obj->secure($txt, $prefix, $suffix);
$txt = $obj->restore($txt);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class strProtect {
	private $dat = array();

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function secure($text, $prefix, $suffix) {
	if (! $prefix) return; if (! $suffix) return;

	$arr = STR::find($text, $prefix, $suffix, false);
	$cnt = count($this->dat) + 1;

	foreach ($arr as $item) {
		$key = $this->getProt($cnt++);
		$this->dat[$key] = $item;

		$text = STR::replace($text, $item, $key);
	}
	return $text;
}

// ***********************************************************
public function restore($text) {
	$arr = $this->dat; if (! $arr) return $text;

	foreach ($arr as $key => $val) {
		$text = STR::replace($text, $key, $val);
	}
	return $text;
}

// ***********************************************************
// storing for future use
// ***********************************************************
public function store($qid) {
	SSV::set("dat", $this->dat, "prot.$qid");
	SSV::set("pfx", $this->pfx, "prot.$qid");
}

public function recall($qid) {
	$this->dat = SSV::get("dat", false, "prot.$qid");
	$this->pfx = SSV::get("pfx", false, "prot.$qid");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getProt($idx) {
	return "pr@t:".$idx."^";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
