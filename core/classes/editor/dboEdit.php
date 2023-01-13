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
* no public methods

*/

incCls("dbase/dbQuery.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dboEdit {

function __construct() {
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$dbo = ENV::getPost("dbo"); if ($dbo != "dboEdit") return;
	$dbs = ENV::getPost("dbs"); if (! $dbs) return;
	$act = ENV::getPost("chk");

	switch ($act) {
		case "tcProps": return $this->tcProps($dbs);
		case "tlProps": return $this->tlProps($dbs);
		case "fcProps": return $this->fcProps($dbs);
		case "flProps": return $this->flProps($dbs);
	}
}

// ***********************************************************
private function tcProps($dbs) { // common table props
	$tbl = ENV::getPost("tbl");  if (! $tbl) return;
	$arr = ENV::getPost("prop"); if (! $arr) return;

	foreach ($arr as $prop => $val) {
		self::dboEx($dbs, "tbl", $tbl, $prop, $val);
	}
}
private function tlProps($dbs) { // lang specific table props
	$tbl = ENV::getPost("tbl");  if (! $tbl) return;
	$arr = ENV::getPost("head"); if (! $arr) return;

	foreach ($arr as $lang => $val) {
		self::dboEx($dbs, "tbl", $tbl, "head.$lang", $val);
	}
}

// ***********************************************************
private function fcProps($dbs) { // common field props
	$fld = ENV::getPost("fld");  if (! $fld) return;
	$arr = ENV::getPost("prop"); if (! $arr) return;

	foreach ($arr as $prop => $val) {
		self::dboEx($dbs, "fld", $fld, $prop, $val);
	}
}
private function flProps($dbs) { // lang specific field props
	$fld = ENV::getPost("fld");  if (! $fld) return;
	$arr = ENV::getPost("head"); if (! $arr) return;

	foreach ($arr as $lang => $val) {
		self::dboEx($dbs, "fld", $fld, "head.$lang", $val);
	}
}

// ***********************************************************
private function dboEx($dbs, $cat, $spec, $prop, $val) {
#	if (! $val) return;
	$vls = array("cat" => $cat, "spec" => $spec, "prop" => $prop, "value" => $val);
	$flt = "cat='$cat' AND spec='$spec' AND prop='$prop'";

	foreach ($vls as $key => $val) {
		$vls[$key] = DBS::secure($val);
	}
	$dbq = new dbQuery($dbs, "dbobjs");
	$dbq->askMe(false);
	$dbq->replace($vls, $flt);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

