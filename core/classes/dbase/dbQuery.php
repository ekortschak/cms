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
$dbq->setWhere($filter);
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
incCls("dbase/recProof.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dbQuery extends dbBasics {
	private $vld; // data validator
	protected $ask = true; // ask for confirmation

function __construct($dbase = "default", $table = "dummy") {
	parent::__construct($dbase, $table);

	$this->setTable($table);
	$this->setValidator($dbase, $table);
}

// ***********************************************************
// data manipulation
// ***********************************************************
public function replace($values, $filter) {
	$chk = $this->isRecord($filter); if ($chk)
	return $this->update($values, $filter);
	return $this->insert($values);
}

// ***********************************************************
public function insert($values) {
	if (! $vls = $this->vld->check($values))       return false;
	if (! $this->vld->b4Ins($vls))                 return false;
	if (! $this->runSQL("mod.ins", $vls))          return false;
	      $this->vld->onIns($vls);                 return $this->inf["lid"];
}
public function update($values, $filter = 1) {
	if (! $vls = $this->vld->check($values))       return false;
	if (! $this->vld->b4Upd($vls, $filter))        return false;
	if (! $this->runSQL("mod.upd", $vls, $filter)) return false;
	      $this->vld->onUpd($vls, $filter);        return $this->inf["aff"];
}
public function delete($filter) {
	if (! $this->vld->b4Del($filter))              return false;
	if (! $this->runSQL("mod.del", 0, $filter))    return false;
	      $this->vld->onDel($filter);              return $this->inf["aff"];
}

// ***********************************************************
private function runSQL($sec, $vls, $flt = 0) {
	$this->setProps($vls); $mod = STR::after($sec, ".");
	$this->setWhere($flt);

	$sql = $this->getStmt($sec);
	$cnf = $this->confirm($sql); if (! $cnf) return false;
	return $this->exec($sql, $mod);
}

// ***********************************************************
// set validator
// ***********************************************************
private function setValidator($dbs, $tbl) {
	$fil = APP::file("dbase/validate/$tbl.php");
	$cls = "recProof";

	if ($fil) { // table specific validator
		include_once $fil;
		$cls = "val_$tbl"; // common validator
	}
	$this->vld = new $cls($dbs, $tbl);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
