<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to manage meta information

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/saveSeo.php");

$obj = new saveSeo();
$obj->exec();
*
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveSeo {

function __construct() {
	if (EDITING != "seo") return;
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$act = ENV::getPost("meta.act"); if (! $act) return;
	$dat = ENV::getPost("data");
	$oid = ENV::getPost("oid");

	$wht = OID::get($oid, "what");   if (! $wht) return;

	if ($wht == "desc")
	$dat = STR::replace($dat, "\n", "_\n");
	$lng = CUR_LANG;

	$ini = new iniWriter();
	$ini->read(CUR_PAGE);
	$ini->set("$lng.$wht", trim($dat));
	$ini->save();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

