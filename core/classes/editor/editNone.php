<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for ineditable files

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class
*/

incCls("editor/editText.php");
incCls("editor/iniMgr.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editNone extends editText  {

function __construct() {
	parent::__construct();

	$this->load("editor/edit.none.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function edit() {
	$ini = new ini(PGE::$dir);
	$typ = $ini->get("props.typ");
	$trg = $ini->get("props_red.trg"); if (! $trg)
	$trg = PGE::$dir;

	$this->set("type", $typ);
	$this->set("target", $trg);
	$this->show();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
