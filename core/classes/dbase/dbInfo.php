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

function __construct($dbase = NV, $table = "dummy") {
	parent::__construct($dbase, $table);
}

// ***********************************************************
// handling databases
// ***********************************************************
public function dbases() {
	$arr = $this->getRecs("inf.dbs", "n"); if (! $arr) return;
	$ign = ".phpmyadmin.sys.mysql.";
	$out = array();

	foreach ($arr as $dbs) {
		if (! $dbs) continue;
		$nam = current($dbs);
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
		$cap = VEC::get($inf, "head", $tbl);
		$cap = VEC::get($inf, "head.$lng", $cap);
		$out[$tbl] = $cap;
	}
	return $out;
}

public function tblPerms($nam = "tbl.access") {
	return array(
		"w"  => "write",
		"ae" => "add & edit", "ad" => "add & delete", "ed" => "edit & delete",
		"a"  => "add", "e"  => "edit", "d"  => "delete",
		"r"  => "read only", "x" => "none"
	);
}

// ***********************************************************
// handling fields
// ***********************************************************
public function fields($table, $fieldmask = "%") {
	$xxx = $this->setTable($table);
	$xxx = $this->setField($table, $fieldmask);
	$arr = $this->getRecs("inf.fds"); if (! $arr) return false;
	$arr = $this->getCol($arr, "Field");
	$lng = CUR_LANG; $out = array();

	foreach ($arr as $fld) {
		$inf = $this->fldProps($table, $fld);
		$cap = VEC::get($inf, "head", $fld);
		$cap = VEC::get($inf, "head.$lng", $cap);
		$out[$fld] = $cap;
	}
	return $out;
}

// ***********************************************************
public function fldList($tbl, $mask = "%", $skip = "ID") {
	$out = parent::fldList($tbl, $mask);
	if ($skip) unset($out[$skip]);
	return $out;
}

// ***********************************************************
public function fldTypes() {
	return array(
		"var" => "Text", "num" => "Number",
		"mem" => "Memo", "dat" => "Date / Time",
	);
}

// ***********************************************************
public function fldLen($typ) {
	switch ($typ) {
		case "var": return $this->getVarLens();
		case "num": return array("int" => "Integer", "dbl" => "Double", "dec" => "Decimal");
		case "dat": return array("dat" => "Date", "dnt" => "Date & Time", "tim" => "Time", "cur" => "Timestamp");
		case "md5": return array(32 => 32);
	}
	return array("mem" => "*");
}

public function fldLenFind($typ, $lng) {
	if ($typ == "mem") return false;
	if ($typ == "var") {
		foreach ($this->getVarLens() as $val) {
			if ($val >= $lng) return $val;
		}	return $val;
	}
	return $lng;
}

private function getVarLens() {
	$out = array(5, 10, 15, 25, 32, 50, 75, 100, 150, 200, 250);
	$out = array_combine($out, $out);
	$out[32] = "32 - MD5";
	return $out;
}


public function fldNull($typ) {
	switch ($typ) {
		case "cur": case "txt": return array("YES" => "YES");
	}
	return array("NULL" => "YES", 	"NOT NULL" => "NO");
}

// ***********************************************************
public function fldPerms() {
	return array("w" => "write", "r" => "read only", "x" => "none");
}

// ***********************************************************
// handling access groups
// ***********************************************************
public function usrGroups($sys = true) {
	$lst = "x.ID.cat.spec"; if (! $sys) $lst.= ".www.user.admin";
	$arr = $this->fields("dbxs");
	return $this->dropSysObjs($arr, $lst);
}

public function usrList($sys = true) {
	$lst = ""; if (! $sys) $lst = "admin.powerman";
	$arr = $this->getDVs("uname"); if (! $arr) return false;
	return $this->dropSysObjs($arr, $lst);
}

public function usrPerms() {
	return array("m" => "member", "x" => "none");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function dropSysObjs($arr, $lst) {
 // drop reserved or delicate items from output array
	if (! $arr) return $arr; $lst = explode(".", $lst);
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
