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
	protected $tpl = "editor/edit.pic.tpl";

function __construct() {
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
public function show() {
	$this->showCR( $this->fil);
	$this->showPic($this->fil);
}

// ***********************************************************
// display
// ***********************************************************
private function showPic($fil) {
	$tpl = new tpl();
	$tpl->load($this->tpl);
	$tpl->set("file", $fil);
	$tpl->show();
}

private function showCR($fil) { // show copyright info
	if (! DB_MODE) return;

	HTW::tag("(CR)-Information", "b");
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
