<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of data filters

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/recFilter.php");

$dbf = new recFilter($table);
$dbf->show();

*/

incCls("dbase/fldFilter.php");
incCls("dbase/dbBasics.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class recFilter extends dbBasics {
	private $fds = array();
	private $flt = array();

function __construct($dbase, $table) {
	parent::__construct($dbase, $table);
	$this->register("$dbase.$table");
	$this->setTable($table);
}

// ***********************************************************
// adding filters
// ***********************************************************
public function addFilter($list) {
	$arr = STR::toArray($list); $lst = $inf = array();

	foreach ($arr as $fld) {
		$inf[$fld] = $this->fldProps($this->tbl, $fld);
		$lst[$fld] = false;
	}
	$this->fds = $inf;
	$this->flt = $lst;
}

public function getFilter() {
	$out = array();

	foreach ($this->flt as $key => $val) {
		if (! $key) continue;

		switch ($key) {
			case "ID": if (! $val) break; $out[] = "ID='$val'"; break;
			default:   $out[] = "$key LIKE '%$val%'";
		}
	}
	return implode(" AND ", $out);
}

// ***********************************************************
// output form
// ***********************************************************
public function show() {
	echo $this->gc();
}

public function gc() {
	$fds = $this->fds; $cnt = 0;
	$vls = OID::getLast($this->oid);

	$sel = new fldFilter($this->dbs);
	$sel->set("oid", $this->oid);

	foreach ($fds as $fld => $inf) {
		$hed = VEC::lng(CUR_LANG, $inf, "head");
		$typ = VEC::get($inf, "dtype"); if (! $typ) continue;
		$val = VEC::get($inf, "fstd");
		$val = VEC::get($vls, $fld, $val);
		$val = CFG::insert($val);

		$inf["head"]  = $hed;
		$inf["perms"] = "w"; if ($typ == "key")
		$inf["dtype"] = "int"; // prevent keys from hiding

		$this->flt[$fld] = $sel->add($inf, $val);
		$cnt++;
	}
	if ($cnt < 1) return;
	return $sel->gc();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
