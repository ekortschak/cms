<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for editing copyright info on pictures

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class
*/

incCls("editor/editText.php");
incCls("dbase/recEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editPic extends editText {

function __construct() {
	parent::__construct();
	DBG::cls(__CLASS__);

	$this->load("editor/edit.pic.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function edit() {
	$this->showCR( $this->file);
	$this->showPic($this->file);
}

// ***********************************************************
// display
// ***********************************************************
private function showPic($fil) {
	parent::set("file", $fil);
	parent::show();
}

private function showCR($fil) { // show copyright info
	if (! DB_MODE) return;

	HTW::tag("&copy;-Information", "b");
	$md5 = md5($fil);

	$dbe = new recEdit("default", "copyright");
	$dbe->setDefault("md5", $md5);
	$dbe->setDefault("holder", "Glaube ist mehr");
	$dbe->setDefault("source", "https://glaubeistmehr.at");
	$dbe->setDefault("perms", "free");
	$dbe->setDefault("verified", 1);

	$dbe->hide("md5,owner,verified");
	$dbe->permit("ed");

	$dbe->findRec("md5='$md5'");
	$dbe->show();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
