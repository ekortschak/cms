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

	$this->read("design/templates/tables/recSel.tpl");
	$this->setOID();
}

// ***********************************************************
// executing selections
// ***********************************************************
protected function exec($dbase, $tbl, $flt) { // recSel templates
	$act = ENV::getPost("rec.act", false);  if (! $act) return;
	$rec = $this->getOidVar("sel", "list"); if (! $rec) return;

	$fld = STR::before($act, "=>");
	$new = STR::after($act, "=>");
	$new = strtolower($new);
	$vls = array($fld => $new);

	$dbq = new dbQuery($dbase, $tbl);
	$dbq->setFilter($flt);
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
