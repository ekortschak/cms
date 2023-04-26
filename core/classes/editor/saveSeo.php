<?php

if (VMODE != "seo") return;

/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to manage meta information
* no public methods
*/

incCls("editor/iniWriter.php");

new saveSeo();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveSeo {

function __construct() {
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$dir = ENV::getPage();

	$act = ENV::getPost("meta.act"); if (! $act) return;
	$dat = ENV::getPost("data");
	$oid = ENV::getPost("oid");

	$wht = OID::get($oid, "what");   if (! $wht) return;

	if ($wht == "desc")
	$dat = STR::replace($dat, "\n", "_\n");
	$lng = CUR_LANG;

	$ini = new iniWriter($dir);
	$ini->set("$lng.$wht", trim($dat));
	$ini->save();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

