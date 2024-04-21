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
	DBG::cls(__CLASS__);

	$this->load("editor/edit.none.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function edit() {
	$dir = PGE::get("pfs.fpath");
	$trg = PGE::get("props_red.trg");
	$typ = PGE::type($dir);

	$this->set("type", $typ);

	switch ($typ) {
		case "red": return $this->redir($trg);
	}
	$this->show();
}

public function redir($trg) {
	if (! $trg) return;

	$this->set("source", APP::link($trg));
	$this->set("target", $trg);
	$this->show("redirect");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
