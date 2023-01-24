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
	$uid = PGE::getUID($file);

	$tpl = new tpl();
	$tpl->load($this->tpl);
	$tpl->set("title", $uid);
	$tpl->set("file", $this->fil);
	$tpl->show();
}

private function showCR($fil) { // show copyright info
	HTW::tag("(CR)-Information", "b");

	if (DB_MODE != "none") {
		$md5 = md5($fil);

		$dbe = new recEdit(NV, "copyright");
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
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
