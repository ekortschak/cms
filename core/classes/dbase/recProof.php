<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for validating data entered by user

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/recProof.php");

$obj = new recProof();
*/

incCls("dbase/dbBasics.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class recProof extends dbBasics {

function __construct($dbase = "default", $table = NV) {
	parent::__construct($dbase, $table);
	$this->setTable($table);
}

// ***********************************************************
// checking fields
// ***********************************************************
protected function mayNull($fld) {
	$inf = $this->fldProps($this->tbl, $fld);
	return VEC::get($inf, "fnull");
}

// ***********************************************************
// checking values before writing to DB
// ***********************************************************
public function check($vls) {
	$vls = $this->checkNull($vls); if (! $vls) return false;
	return $this->checkVals($vls);
}

// ***********************************************************
protected function checkNull($vls) { // may be used to overrule values
	foreach ($vls as $fld => $val) {
		if ($this->mayNull($fld)) continue;
		return ERR::msg("fld.empty", "$tbl.$fld");
	}
	return $vls;
}
protected function checkVals($vls)  {
//  things that have to be checked by application
	return $vls;
}

// ***********************************************************
// when to impede writing to DB
// ***********************************************************
public function b4Ins($vls      ) { return true; }
public function b4Upd($vls, $flt) { return true; }
public function b4Del(      $flt) { return true; }

// ***********************************************************
// clean up after writing to DB, e.g. referential integrity
// ***********************************************************
public function onIns($vls)       { }
public function onUpd($vls, $flt) { }
public function onDel(      $flt) { }

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
