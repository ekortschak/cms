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

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec() {
	if (EDITING != "seo") return;

	$this->save();
}

// ***********************************************************
// visibility & sort order
// ***********************************************************
private function save() {
	$act = ENV::getPost("meta.act"); if (! $act) return false;
	$oid = ENV::getPost("oid");      if (! $oid) return false;
	$wht = ENV::getPost("wht");
	$dat = ENV::getPost("data");
	$loc = OID::get($oid, "loc");

	if ($wht == "desc")
	$dsc = STR::replace($dsc, "\n", "_\n");
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

