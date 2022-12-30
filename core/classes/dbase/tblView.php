<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of db tables
*/

incCls("tables/htm_table.php");
incCls("dbase/dbQuery.php");
incCls("dbase/dbInfo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tblView extends htm_table {
	private $flt = array();

function __construct() {
	parent::__construct();
	$this->load("tables/recView.tpl");
}

// ***********************************************************
// preparing
// ***********************************************************
public function setTable($dbase, $table, $flt = "") {
	$this->exec($dbase, $table, $flt);

    $dbq = new dbQuery($dbase, $table);
    $chk = $dbq->isTable($table); if (! $chk) return;
    $dat = $dbq->tblProps($table);

	$fds = VEC::get($dat, "fields", "*");
	$ord = VEC::get($dat, "sortby", "");
	$tmp = VEC::get($dat, "where", "");
	$lst = array();

	if ($tmp) $lst[] = $tmp;
	if ($flt) $lst[] = $flt;

	$flt = implode(" AND ", $lst);

    $xxx = $dbq->setQuery($table, $fds, $flt, $ord);
    $arr = $dbq->getRecs(); if (! $arr) return;
	$fds = $arr[0];

   	$this->addRows($arr);

    foreach ($fds as $fld => $val) {
		$inf = $dbq->fldProps($table, $fld);
		if (! isset($inf["vals"])) $inf["vals"] = "";

		$this->addCol($fld, $inf);
	}
}

protected function getPage() {
    $pge = $this->get("cur", 0);
    $rep = $this->get("lines", $this->lns);
    $lst = $this->get("last", 0) - 1;

    switch (ENV::getPost("act", "x")) {
        case "p": $pge = $pge - 1; break;
        case "n": $pge = $pge + 1; break;
        case "l": $pge = $lst;     break;
        default:  $pge = 0;
    }
    $max = $this->getPageNum($lst);
    $pge = CHK::range($pge, $max);
    $xxx = $this->set("page", $pge);
    return $pge;
}

// ***********************************************************
// dummy method for derived classes
// ***********************************************************
protected function exec($dbase, $tbl, $flt) {
// execute updates, inserts and deletes
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
