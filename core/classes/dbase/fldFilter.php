<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create user input fields for db tables
*/

incCls("dbase/fldEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class fldFilter extends fldEdit {

function __construct() {
	parent::__construct();
	$this->load("input/recFilter.tpl");
}

// ***********************************************************
// adding filters
// ***********************************************************
public function add($inf, $val) {
	$tit = VEC::get($inf, "head", "?");
	$typ = VEC::get($inf, "dtype");
	$fnm = VEC::get($inf, "fname", "?");
	$ref = VEC::get($inf, "vals"); if ($ref) $typ = "cmb";
	$fxs = VEC::get($inf, "perms");
	$out = false;

	$typ = $this->getType($typ, $fxs); if (! $typ) return;

	switch ($typ) {
		case "com": $out = $this->combo ($tit, $ref, $val); break;
		case "mem": $out = $this->tarea ($tit, $val); break;
		default:	$out = $this->input ($tit, $val);
	}
	$this->setProp("fname", $fnm);
	return $out;
}

// ***********************************************************
protected function getType($typ, $fxs) {
	$typ = STR::left($typ);
	if ($typ == "pwd") return false; // primary keys
	if ($typ == "hid") return false; // primary keys
	if ($typ == "key") return false; // primary keys
	if ($typ == "cur") return false; // timestamps
	if ($typ == "ski") return false; // skip field
	return $typ;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
