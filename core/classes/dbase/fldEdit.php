<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create user input fields for db tables

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/fldEdit.php");

$fed = new fldEdit($dbase);
$fed->add($fldInfo, $value)
$fed->show();
*/

incCls("input/selector.php");
incCls("dbase/dbInfo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class fldEdit extends selector {
	private $dbs = NV;

function __construct($dbs) {
	parent::__construct();
	parent::load("input/recEdit.tpl");

	$this->dbs = $dbs;

	DIC::read("dbase/ref");
}

// ***********************************************************
// adding input fields
// ***********************************************************
public function add($inf, $val) {
	$tit = $inf->get("head",  "?");
	$fnm = $inf->get("fname", "?");
	$typ = $inf->get("dtype");
	$nul = $inf->get("fnull");
	$ref = $inf->get("input");
	$fxs = $inf->get("perms");

	$typ = $this->fldType($typ, $ref);
	$typ = $this->fldPerms($typ, $fxs); if (! $typ) return;
	$ref = $this->fldVals($ref);
	$out = false;

	switch ($typ) {
		case "hid": TAN::set($fnm, $val); return false;

		case "ron":
			$val = $this->fldValue($ref, $val);
			$out = $this->ronly($tit, $val); break;

		case "mem": $out = $this->tarea($fnm, $val); break;
		case "pwd": $out = $this->pwd  ($fnm); break;

		case "cmb":	$out = $this->combo($fnm, $ref, $val); break;
		case "rat":	$out = $this->image($fnm, $val, "rating.png"); break;
		case "chk": $out = $this->check($fnm, $val); break;
		case "yon": $out = $this->boole($fnm, $val); break;

		default:	$out = $this->input($fnm, $val);
	}
	$this->set("fnull", $nul ? "*" : "");
	$this->setProp("title", $tit);
	$this->setProp("fnull", $nul);

	return $out;
}

// ***********************************************************
// define inputbox format
// ***********************************************************
protected function fldType($typ, $ref) {
	if (! $ref) return $typ;

	switch(STR::left($ref)) {
		case "rat": return "rat"; // rating
		case "che": return "chk"; // checkbox
		case "boo": return "chk"; // bool
	}
	return "cmb";
}

// ***********************************************************
protected function fldVals($ref) {
 // provide list of preset values where available
	if (! $ref) return false;

	$fnc = STR::before($ref, ":");
	$ref = STR::after($ref, ":");

	switch(STR::left($fnc)) {
		case "folders": return APP::dirs($ref);
		case "files":   return APP::files($ref);
		case "tables":  return $this->dbInfo("tbl");
		case "fields":  return $this->dbInfo("fld", $ref);

		case "dic": $ref = DIC::get("ref.$ref"); break;
	}
	$out = STR::toAssoc($ref);
	return $out;
}

// ***********************************************************
protected function fldPerms($typ, $fxs) {
 // never show primary keys, time stamps, fields to skip ...
	if (STR::features("key.cur.ski", $typ)) return false;
	if (STR::features("rat", $typ)) return $typ;

	if ($fxs == "h") return "hid"; // no write access
	if ($fxs == "w") return $typ;

	return "ron"; // no write access
}

// ***********************************************************
protected function fldValue($ref, $key) { // translate $ref in case of ReadOnly
	if (! is_array($ref)) return $key;
	if (! array_key_exists($key, $ref)) return $key;
	return $ref[$key];
}

// ***********************************************************
// handling dbInfo
// ***********************************************************
protected function dbInfo($typ, $prm = "") {
	$dbi = new dbInfo($this->dbs);
	if ($typ == "tbl") return $dbi->tables();
	if ($typ == "fld") return $dbi->fields($prm);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
