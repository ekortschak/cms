<?php
/* ***********************************************************
// INFO
// ***********************************************************
dbo editor, used to manage dbo properties

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/dboEdit.php");

$obj = new dboEdit();
$obj->exec();
*
*/

incCls("dbase/dbQuery.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dboEdit {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec() {
	$act = VEC::get($_POST, "val_chk");
	$dbs = VEC::get($_POST, "val_dbs");  if (! $dbs) return;

	if (! STR::contains(".tcProps.tlProps.fcProps.flProps.", ".$act.")) return;
	self::$act($dbs);
}

// ***********************************************************
private function tcProps($dbs) { // common table props
	$tbl = VEC::get($_POST, "val_tbl");  if (! $tbl) return;
	$arr = VEC::get($_POST, "val_prop"); if (! $arr) return;

	foreach ($arr as $prop => $val) {
		if (! $prop) continue;
		$vls = array("cat" => "tbl", "spec" => $tbl, "prop" => $prop, "value" => $val);
		self::dboEx($dbs, $vls, "cat='tbl' AND spec='$tbl' AND prop='$prop'");
	}
}
private function tlProps($dbs) { // lang specific table props
	$tbl = VEC::get($_POST, "val_tbl");  if (! $tbl) return;
	$arr = VEC::get($_POST, "val_head"); if (! $arr) return;

	foreach ($arr as $lang => $val) {
		if (! $val) continue; $prop = "head.$lang";
		$vls = array("cat" => "tbl", "spec" => $tbl, "prop" => $prop, "value" => $val);
		self::dboEx($dbs, $vls, "cat='tbl' AND spec='$tbl' AND prop='$prop'");
	}
}

// ***********************************************************
private function fcProps($dbs) { // common field props
	$fld = VEC::get($_POST, "val_fld");  if (! $fld) return;
	$arr = VEC::get($_POST, "val_prop"); if (! $arr) return;

	foreach ($arr as $prop => $val) {
		if (! $prop) continue;
		$vls = array("cat" => "fld", "spec" => $fld, "prop" => $prop, "value" => $val);
		self::dboEx($dbs, $vls, "cat='fld' AND spec='$fld' AND prop='$prop'");
	}
}
private function flProps($dbs) { // lang specific field props
	$fld = VEC::get($_POST, "val_fld");  if (! $fld) return;
	$arr = VEC::get($_POST, "val_head"); if (! $arr) return;

	foreach ($arr as $lang => $val) {
		if (! $val) continue; $prop = "head.$lang";
		$vls = array("cat" => "fld", "spec" => $fld, "prop" => $prop, "value" => $val);
		self::dboEx($dbs, $vls, "cat='fld' AND spec='$fld' AND prop='$prop'");
	}
}

// ***********************************************************
private function dboEx($dbs, $vls, $flt) {
	foreach ($vls as $key => $val) {
		$vls[$key] = STR::secure($val);
	}
	$dbq = new dbQuery($dbs, "dbobjs");
	$dbq->askMe(false);
	$dbq->replace($vls, $flt);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

