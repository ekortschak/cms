<?php

if (! DB_CON) return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

incCls("dbase/dbQuery.php");

new saveDbo();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveDbo extends saveMany {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$dbo = $this->get("dbo"); if (  $dbo != "dboEdit") return;
	$act = $this->get("chk"); if (! $act) return;
	$dbs = $this->get("dbs"); if (! $dbs) return;
	$tbl = $this->get("tbl"); if (! $tbl) return;
	$fld = $this->get("fld");

	switch ($act) {
		case "tcProps": return $this->tcProps($dbs, $tbl);
		case "tlProps": return $this->tlProps($dbs, $tbl);
		case "fcProps": return $this->fcProps($dbs, $fld);
		case "flProps": return $this->flProps($dbs, $fld);
	}
}

// ***********************************************************
private function tcProps($dbs, $tbl) { // common table props
	$arr = $this->get("prop"); if (! $arr) return;

	foreach ($arr as $prop => $val) {
		self::dboEx($dbs, "tbl", $tbl, $prop, $val);
	}
}
private function tlProps($dbs, $tbl) { // lang specific table props
	$arr = $this->get("head"); if (! $arr) return;

	foreach ($arr as $lang => $val) {
		self::dboEx($dbs, "tbl", $tbl, "head.$lang", $val);
	}
}

// ***********************************************************
private function fcProps($dbs, $fld) { // common field props
	$arr = $this->get("prop"); if (! $arr) return;

	foreach ($arr as $prop => $val) {
		self::dboEx($dbs, "fld", $fld, $prop, $val);
	}
}
private function flProps($dbs, $fld) { // lang specific field props
	$arr = $this->get("head"); if (! $arr) return;

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

