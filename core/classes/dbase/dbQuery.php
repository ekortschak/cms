<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of mysql queries
* epecially data modification

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/dbQuery.php)";

$dbq = new dbQuery($dbs, $table);
$dbq->setFilter($filter);
$dbq->setOrder($order);

$arr = $dbq->query($filter); 	// return 1st record found
$chk = $dbq->isTable();
$chk = $dbq->isField();

$values = array(
	$field1 = "value1",
	$field2 = "value2"
);
$dbq->replace($values);			// insert or replace
$dbq->insert($values);			// insert data
$dbq->update($values, $filter);	// update record
$dbq->delete($filter);			// delete record

*/

incCls("dbase/dbBasics.php");
incCls("dbase/tblValidate.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dbQuery extends dbBasics {
	private $vld; // data validator
	protected $ask = true; // ask for confirmation

function __construct($dbase, $table = "dummy") {
	parent::__construct($dbase, $table);

	$this->setValidator($dbase, $table);
}

// ***********************************************************
// data manipulation
// ***********************************************************
public function replace($values, $filter) {
	if ($this->isRecord($filter))
	return $this->update($values, $filter);
	return $this->insert($values);
}

public function insert($values) {
	$vls = $this->vld->check("i", $values);	if (! $vls) return false;
	$erg = $this->runSQL("mod.ins", $vls);  if (  $erg)
	$xxx = $this->vld->onIns($vls);
	return $erg;
}
public function update($values, $filter = 1) {
	$vls = $this->vld->check("u", $values); if (! $vls) return false;
	$erg = $this->runSQL("mod.upd", $vls, $filter); if ($erg)
	$xxx = $this->vld->onUpd($vls, $filter);
	return $erg;
}
public function delete($filter) {
	$chk = $this->vld->b4Del($filter); if (! $chk) return false;
	$erg = $this->runSQL("mod.del", 0, $filter); if ($erg)
	$xxx = $this->vld->onDel($filter);
	return $erg;
}

// ***********************************************************
private function runSQL($sec, $vls, $flt = 0) {
	if ($vls) $this->setProps($vls);
	if ($flt) $this->setFilter($flt);

	$sql = $this->fetch($sec);
	$mod = STR::after($sec, ".");

	$cnf = $this->confirm($sql); if (! $cnf) return false;
	return $this->exec($sql, $mod);
}

// ***********************************************************
private function setValidator($dbs, $tbl) {
	$fil = APP::file("dbase/validate/$tbl.php");

	if (! $fil) { // table specific validator
		$this->vld = new tblValidate($dbs, $tbl);
		return;
	}
	include_once($fil); $cls = "val_$tbl"; // common validator
	$this->vld = new $cls($dbs, $tbl);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
