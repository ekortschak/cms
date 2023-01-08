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
	return $this->getKey("db.field", $arr);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
