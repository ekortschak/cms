<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to manage meta information

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/seoEdit.php");

$obj = new seoEdit();
$obj->exec();
*
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class seoEdit {

function __construct() {
	if (EDITING != "seo") return;
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$act = ENV::getPost("meta.act"); if (! $act) return false;
	$wht = ENV::getPost("wht"); // keys or desc
	$dat = ENV::getPost("data");
	$loc = OID::get($oid, "loc");

	if ($wht == "desc")
	$dat = STR::replace($dat, "\n", "_\n");
	$lng = CUR_LANG;

	$ini = new iniWriter();
	$ini->read($loc);
	$ini->set("$lng.$wht", trim($dat));
	$ini->save();
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

