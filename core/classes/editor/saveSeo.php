<?php

if (VMODE != "seo") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

new saveSeo();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveSeo extends saveMany {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$dir = ENV::getPage();

	$act = $this->get("meta.act"); if (! $act) return;
	$dat = $this->get("data");
	$oid = $this->get("oid");

	$wht = OID::get($oid, "what");   if (! $wht) return;

	if ($wht == "desc")
	$dat = STR::replace($dat, "\n", "_\n");
	$lng = CUR_LANG;

	$ini = new iniWriter();
	$ini->read($dir);
	$ini->set("$lng.$wht", trim($dat));
	$ini->save();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

