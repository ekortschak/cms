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
	$tit = VEC::get($inf, "head",  "?");
	$fnm = VEC::get($inf, "fname", "?");
	$typ = VEC::get($inf, "dtype");
	$nul = VEC::get($inf, "fnull");
	$ref = VEC::get($inf, "input");
	$fxs = VEC::get($inf, "perms");

	$typ = $this->getType($typ, $ref);
	$typ = $this->chkType($typ, $fxs); if (! $typ) return;
	$ref = $this->chkRef($ref);
	$out = false;

	$this->set("fnull", $nul);

	switch ($typ) {
		case "hid": TAN::set($fnm, $val); return false;

		case "ron":
			$val = $this->chkROnly($ref, $val);
			$out = $this->ronly($tit, $val); break;

		case "mem": $out = $this->tarea($fnm, $val); break;
		case "pwd": $out = $this->pwd  ($fnm); break;

		case "cmb":	$out = $this->combo($fnm, $ref, $val); break;
		case "rat": $out = $this->image($fnm, $val, "rating.png"); break;
		case "chk": $out = $this->check($fnm, $val); break;
		case "yon": $out = $this->boole($fnm, $val); break;

		default:	$out = $this->input($fnm, $val);
	}
	$this->setProp("title", $tit);
	$this->setProp("fnull", $nul);

	return $out;
}

// ***********************************************************
protected function getType($typ, $ref) {
	if (! $ref) return $typ;

	switch(STR::left($ref)) {
		case "rat": return "rat"; // rating
		case "che": return "chk"; // checkbox
		case "boo": return "chk"; // bool
	}
	return "cmb";
}

// ***********************************************************
protected function chkType($typ, $fxs) {
	if (STR::features("key.cur.ski", $typ)) return false; // primary keys, time stamps, fields to skip ...

	if ($fxs == "h") return "hid"; // no write access
	if ($fxs != "w") {
		if ($typ == "chk") return "yon";
		return "ron"; // no write access
	}
	return $typ;
}

// ***********************************************************
protected function chkRef($ref) {
	if (! $ref) return false;

	$fnc = STR::before($ref, ":");
	$ref = STR::after($ref, ":");

	switch(STR::left($fnc)) {
		case "folders": return APP::folders($ref);
		case "files":   return APP::files($ref);
		case "tables":  return $this->getDbInfo("tbl");
		case "fields":  return $this->getDbInfo("fld", $ref);

		case "dic": $ref = DIC::get("ref.$ref"); break;
	}
	$out = STR::toAssoc($ref);
	return $out;
}

// ***********************************************************
protected function chkROnly($ref, $key) {
	if (! is_array($ref)) return $key;
	if (! array_key_exists($key, $ref)) return $key;
	return $ref[$key];
}

// ***********************************************************
// handling dbInfo
// ***********************************************************
protected function getDbInfo($typ, $prm = "") {
	$dbi = new dbInfo($this->dbs);
	if ($typ == "tbl") return $dbi->tables();
	if ($typ == "fld") return $dbi->fields($prm);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
