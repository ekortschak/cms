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
	$uid = $ini->getUID();
	$typ = $ini->getType("props.typ");
	$trg = $ini->get("props_red.trg");

	$this->set("type", $typ);
	$this->set("target", $trg);

	switch ($typ) {
		case "red": return $this->redir($trg);
	}
	$this->show();
}

public function redir($trg) {
	if (! $trg) return;
	$url = APP::link($trg);

	$this->set("source", $url);
	$this->show("redirect");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
