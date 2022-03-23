<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create user input fields for db tables
*/

incCls("input/selector.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class fldEdit extends selector {
	protected $xlate = false;

function __construct() {
	parent::__construct();

	if (CUR_DEST == "screen")
	$this->read("design/templates/input/recEdit.tpl");
	$this->read("dbase/ref/gim.ini");
}

// ***********************************************************
// overruled methods
// ***********************************************************
protected function setVal($key, $vls, $sel) {
	$sel = $this->findVal($vls, $sel);
	$xxx = $this->set($key, $sel); // for external use
	return $sel;
}

// ***********************************************************
// adding input fields
// ***********************************************************
public function add($inf, $fxs, $val) {
	$tit = VEC::get($inf, "head", "?");
	$fnm = VEC::get($inf, "fname", "?");
	$typ = VEC::get($inf, "dtype");
	$nul = VEC::get($inf, "fnull"); if ($nul) $nul = "*";
	$ref = VEC::get($inf, "input");

	$typ = $this->getType($typ, $ref);
	$typ = $this->chkType($typ, $fxs); if (! $typ) return;
	$out = false;

	$ref = $this->chkRef($ref);

	$this->set("fnull", $nul);

	switch ($typ) {
		case "hid": TAN::store($fnm, $val); break;

		case "img": $out = $this->image($tit, $val, "rating.png"); break;
#		case "img": $out = $this->image($tit, $val, "rating.png"); break;

		case "ron": $out = $this->ronly($tit, $val); break;
		case "com": $out = $this->combo($tit, $ref, $val); break;
		case "chk": $out = $this->check($tit, $val); break;
		case "mem": $out = $this->tarea($tit, $val); break;
		case "pwd": $out = $this->pwd  ($tit); break;
		default:	$out = $this->input($tit, $val);
	}
	if ($typ != "hid") $this->setProp("fname", $fnm);
	return $out;
}

// ***********************************************************
protected function getType($typ, $ref) {
	if (! $ref) return $typ;

	switch(STR::left($ref)) {
		case "rat": return "img";
		case "che": return "chk";
		case "boo": return "chk";
	}
	return "combo";
}

// ***********************************************************
protected function chkType($typ, $fxs) {
	$typ = STR::left($typ);
	if ($fxs == "h")   return "hid"; // no write access
	if ($fxs != "w")   return "ron"; // no write access
	if ($typ == "key") return false; // primary keys
	if ($typ == "cur") return false; // timestamps
	if ($typ == "ski") return false; // skip field
	return $typ;
}

// ***********************************************************
protected function chkRef($ref) {
	if (! $ref) return false;

	$fnc = STR::before($ref, ":");
	$ref = STR::after($ref, ":");

	switch(STR::left($fnc)) {
		case "ref": return STR::toAssoc(DIC::get("ref.$ref"));
		case "fol": return APP::folders($ref);
		case "fil": return APP::files($ref);
		case "tab": return DBS::tables();
		case "fie": return DBS::fields($ref);
	}
	$out = STR::toAssoc($ref);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
