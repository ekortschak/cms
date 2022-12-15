<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of data display using htm-tables

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/tblMgr.php");

$few = new tblMgr($dbase, $table);
$few->reset();
$few->setTable($table);
$few->addFilter($fields);
$few->permit("w");
$few->setProp($index, $prop, $value);
$few->show();

if ($few->act) {
	// do whatever is required
}

*/

incCls("dbase/dbBasics.php");
incCls("other/items.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tblMgr extends dbBasics {
	protected $dbs = "";			// dbase to operate on
	protected $tbl = "";			// table to operate on
	protected $flt = "";            // record filter
	protected $fds = array();		// fld descriptions as read by inifile
	protected $rec = array();		// current record on display

	protected $few;					// data viewer or editor
	protected $prp;					// properties to pass on
	protected $cnt = 0;          	// number of records

function __construct($dbase, $table) {
	parent::__construct($dbase, $table);
	$this->register("$dbase.$table");

	$this->dbs = $dbase;
	$this->tbl = $table;

	$rec = OID::get($this->oid, "rec", "list");

	$this->set("rec", $rec);
	$this->prp = new items();
}

// ***********************************************************
// preparing view according to table info
// ***********************************************************
public function addFilter($filter) { $this->flt = $filter; }

public function permit($value = "x") {
	$this->set("perms", $value);
}

public function setType($field, $type) {
	switch (STR::left($type)) {
		case "hide":  case "hidden": $type = "hid"; break;
		case "ronly": case "locked": $type = "ron"; break;
	}
    $this->setProp($field, "type", $type);
}

// ***********************************************************
public function setProp($field, $prop, $value) {
	$this->prp->addItem($field);
	$this->prp->setProp($field, $prop, $value);
}

// ***********************************************************
public function hide($fields, $value = true) {
    $lst = STR::toArray($fields); if (! $value) return;

	foreach ($lst as $fld) {
		$this->setProp($fld, "hide", true);
	}
}

public function stdVal($field, $value) {
	$this->setProp($field, "fstd", $value);
}
public function fixVal($field, $value) {
	$this->setProp($field, "value", $value);
	$this->setProp($field, "fstd", $value);
    $this->setProp($field, "dtype", "ronly");
}

// ***********************************************************
// display methods
// ***********************************************************
public function show($recID = 0) {
	$recID = intval($this->get("rec", $recID));

	switch ($recID) {
		case 0:  $this->tblView(); break;
		default: $this->recEdit($recID);
	}
}

public function act() {
	return ENV::getPost("rec.act", false);
}

// ***********************************************************
private function tblView() {
	incCls("dbase/tblFilter.php");
	incCls("dbase/tblView.php");

	$dbs = $this->dbs;
	$tbl = $this->tbl;
	$prp = $this->prp->getItems();

	$sel = new tblFilter($dbs, $tbl); // filter
	$sel->set("oid", $this->oid);
	$sel->addFilter($this->flt);
	$sel->show();

	$dbt = new tblView(); // data
	$dbt->set("oid", $this->oid);
	$dbt->setTable($dbs, $tbl, $sel->getFilter());
	$dbt->mergeProps($prp);
	$dbt->merge($this->vls);
	$dbt->show();

	$this->rec = $dbt->getRec();
	$this->cnt = $dbt->rowCount();
}

// ***********************************************************
private function recEdit($recID) {
	incCls("dbase/recEdit.php");

	$prp = $this->prp->getItems();

	$dbe = new recEdit($this->dbs, $this->tbl);
	$dbe->enable("t");
	$dbe->set("oid", $this->oid);
	$dbe->mergeProps($prp);
	$dbe->merge($this->vls);
	$dbe->findRec($recID);
	$dbe->permit($this->getPerms($recID));
	$dbe->show();

	$this->rec = $dbe->getRec();
	$this->cnt = 0;
}

// ***********************************************************
// retrieving values
// ***********************************************************
public function getVal($field, $default = NV) {
	return VEC::get($this->rec, $field, $default);
}

protected function getPerms($recID) {
	$rgt = $this->get("perms", "std"); if ($recID > 0) return $rgt;
	if ($rgt != "w") return $rgt;
	return "a";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
