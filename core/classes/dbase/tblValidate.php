<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for validating data entered by user

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/tblValidate.php");

$obj = new tblValidate();
*/

incCls("dbase/dbBasics.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tblValidate extends dbBasics {

function __construct($dbase, $table) {
	parent::__construct($dbase, $table);
	$this->setTable($table);
}

// ***********************************************************
// checking values before writing to DB
// ***********************************************************
public function check($act, $vls, $flt = false) {
#	unset($vls["ID"]);
	$vls = $this->checkNull($vls);
	$vls = $this->checkVals($vls); if (! $vls) return false;

	if ($act == "i") return $this->b4Ins($vls);
	if ($act == "u") return $this->b4Upd($vls, $flt);
	return false;
}

// ***********************************************************
protected function checkNull($vls) {
	foreach ($vls as $fld => $val) {
		$inf = $this->fldProps($this->tbl, $fld); #if (! $inf) continue;
		$nul = VEC::get($inf, "fnull"); if ($nul) continue;

		if (! $val)
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
public function b4Ins($vls)       { return $vls; }
public function b4Upd($vls, $flt) { return $vls; }
public function b4Del(      $flt) { return true; }

// ***********************************************************
// clean up after writing to DB, e.g. referential integrity
// ***********************************************************
public function onIns($vls)       { }
public function onUpd($vls, $flt) { }
public function onDel($flt)       { }

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
