<?php
/* ***********************************************************
// INFO
// ***********************************************************
offers multiple records for selection (check box)

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("tables/sel_table.php");

$few = new sel_table();
$few->setTable($dbase, $table, "cat='tbl'");
$few->setButton($group, $perm);
$few->show();

if ($few->act) {
	// do whatever is required
}

*/

incCls("dbase/tblView.php");
incCls("dbase/dbQuery.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sel_table extends tblView {

function __construct() {
	parent::__construct();
	$this->load("tables/recSel.tpl");
	$this->register();
}

// ***********************************************************
// executing selections
// ***********************************************************
protected function exec($dbase, $tbl, $flt) { // recSel templates
	$act = ENV::getPost("rec.act", false);      if (! $act) return;
	$rec = $this->recall("sel", "list"); if (! $rec) return;

	$act = strtolower($act);

	$fld = STR::before($act, "=>");
	$new = STR::after($act, "=>");
	$vls = array($fld => $new);

	$dbq = new dbQuery($dbase, $tbl);
	$dbq->setWhere($flt);
	$dbq->askMe(false);

	foreach ($rec as $key => $val) {
		$dbq->update($vls, "ID='$key'");
	}
}

// ***********************************************************
// Ok buttons
// ***********************************************************
public function setButton($group, $perm) {
	$this->set("action", strtoupper("$group   =>   $perm"));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
