<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to handle DB objects

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/dropBox.php");

$box = new dropBox();
$box->getDbase();
$box->getTable($dbs);
$box->getField($dbs, $tpl);
$box->show();
*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dboBox extends dropBox {

function __construct() {
	parent::__construct();
    $this->load("menus/dropDbo.tpl");
}

// ***********************************************************
// show db tables and fields
// ***********************************************************
public function getDbase() {
	$arr = DBS::dbases();
	return $this->getKey("pic.dbase", $arr);
}

public function getTable($dbs) {
	$arr = DBS::tables($dbs);
	return $this->getKey("pic.table", $arr);
}

public function getField($dbs, $tbl) {
	$arr = DBS::fields($dbs, $tbl);
	return $this->getKey("pic.field", $arr);
}
public function getFilter($dbs, $tbl) {
	$arr = DBS::fields($dbs, $tbl);
	return $this->getKey("pic.filter", $arr);
}

// ***********************************************************
// show user related features
// ***********************************************************
public function getGroups($dbs, $all = true) {
	$arr = DBS::pgroups($dbs, $all); // all or only user defined groups
	return $this->getKey("pic.group", $arr);
}

public function getPrivs($mds) {
	switch ($mds) {
		case "t": $arr = array("w"  => "write", "ae" => "add & edit", "ad" => "add & delete", "ed" => "edit & delete", "a"  => "add", "e"  => "edit", "d"  => "delete", "r"  => "read only", "x" => "none"); break;
		case "f": $arr = array("w" => "write", "r" => "read only", "x" => "none"); break;
		case "g": $arr = array("m" => "member", "x" => "none"); break;
		default: return false;
	}
	return $this->getKey("pic.privs", $arr);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
