<?php
/* ***********************************************************
// INFO
// ***********************************************************
needed to write changes to tabsets.ini files
case sensitivity applies to keys

// ***********************************************************
// HOW TO USE
// ***********************************************************
$edt = new tabEdit();
$edt->set($key, $value);
$edt->save();

*/

incCls("editor/iniWriter.php");
incCls("input/confirm.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabEdit extends iniWriter {

function __construct($inifile) {
	parent::__construct($inifile);

	$this->read($inifile);
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function savePost($file = NV) {
	$arr = OID::values(); if (! $arr) return;

	$typ = VEC::get($arr, "typ", "root");
	$tpc = VEC::get($arr, "std", ""); if ($typ != "select") $tpc = "";
	$std = STR::afterX($tpc, $tab);

	if (isset($arr["std"])) $arr["std"] = $tpc;

	$this->setProps($arr);
	$this->save($file);
}

// ***********************************************************
// methods
// ***********************************************************
public function confirm($msg, $val) {
	$cnf = new confirm();
	$cnf->dic($msg, $val);
	$cnf->show();

	$this->act = $cnf->act();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
