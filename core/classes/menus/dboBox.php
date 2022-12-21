<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/dropBox.php");

$box = new dropBox();
$box->setSpaces($before, $after);
$box->getKey($qid, $values, $selected);
$box->getVal($qid, $values, $selected);
$box->show();
*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dboBox extends dropBox {

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/dboBox.tpl");
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
public function getPriv() {
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
