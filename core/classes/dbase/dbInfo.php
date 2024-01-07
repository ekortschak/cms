<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of mysql queries.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/dbQuery.php");

$dbi = new dbInfo($table);
*/

incCls("dbase/dbBasics.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dbInfo extends dbBasics {

function __construct($dbase = "default", $table = NV) {
	parent::__construct($dbase);
	$this->setTable($table);
}

// ***********************************************************
// handling databases
// ***********************************************************
public function dbases() {
	$arr = $this->getRecs("inf.dbs", "n"); if (! $arr) return;
	$ign = ".phpmyadmin.sys.mysql.";
	$out = array();

	foreach ($arr as $dbs) {
		if (! $dbs) continue; $nam = current($dbs);
		if (STR::contains($nam, "_schema")) continue;
		if (STR::contains($ign, ".$nam."))  continue;
		$out[$nam] = $nam;
	}
	return $out;
}

// ***********************************************************
// handling tables
// ***********************************************************
public function tables($tablemask = "%") {
	$xxx = $this->setMasks($tablemask);
	$arr = $this->getRecs("inf.tbs", "n"); if (! $arr) return false;
	$arr = $this->getCol($arr, 0);
	$lng = CUR_LANG; $out = array();

	foreach ($arr as $tbl) {
		$inf = $this->tblProps($tbl);
		$cap = VEC::lng(CUR_LANG, $inf, "head", $tbl);
		$out[$tbl] = $cap;
	}
	return $out;
}

// ***********************************************************
// handling fields
// ***********************************************************
public function fields($table) {
	$xxx = $this->setTable($table);
	$arr = $this->getRecs("inf.fds"); if (! $arr) return false;
	$arr = $this->getCol($arr, "Field");
	$lng = CUR_LANG; $out = array();

	foreach ($arr as $fld) {
		$inf = $this->fldProps($table, $fld);
		$cap = VEC::lng(CUR_LANG, $inf, "head", $fld);
		$out[$fld] = $cap;
	}
	return $out;
}

// ***********************************************************
// general info
// ***********************************************************
public function fldTypes() {
	return $this->getValues("opts.ftypes");
}

// ***********************************************************
public function fldLen($typ) {
	return $this->getValues("opts.flen.$typ");
}

public function fldLenFind($typ, $lng) {
	if ($typ == "mem") return false;
	if ($typ != "var") return $lng;

	$arr = $this->fldLen($typ);

	foreach ($arr as $val) {
		if ($val >= $lng) return $val;
	}
	return $val;
}

// ***********************************************************
public function fldNull($typ) {
	switch ($typ) {
		case "cur": case "txt": return array("NULL" => "YES");
	}
	return array("NULL" => "YES", "NOT NULL" => "NO");
}

// ***********************************************************
// handling access groups
// ***********************************************************
public function usrGroups($sys = true) {
	$lst = "x.ID.cat.spec"; if (! $sys) // eliminate non group fields
	$lst.= ".www.user.admin"; // eliminate system groups if needed

	$arr = $this->fields("dbxs");
	return $this->dropSysObjs($arr, $lst);
}

// ***********************************************************
private function dropSysObjs($arr, $lst) {
 // drop reserved or delicate items from output array
	if (! $arr) return $arr; $lst = STR::split($lst, ".");
	if (! $lst) return $arr;

	foreach ($lst as $itm) {
		unset($arr[$itm]);
	}
	return $arr;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
