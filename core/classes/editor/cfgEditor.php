<?php
/* ***********************************************************
// INFO
// ***********************************************************
simple ini editor

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/cfgEditor.php");

$obj = new cfgEditor();
$obj->show($file);
*/

incCls("editor/act.mnuEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class cfgEditor {
	private $fil = ""; // filename without root
	private $src = ""; // template in APP_FBK
	private $dst = ""; // destination in APP_DIR
	private $cur = ""; // currently available of both

function __construct() {}

// ***********************************************************
// display input fields by sections
// ***********************************************************
public function show($fil, $sec = "text") {
	$this->setFile($fil);
	$this->save();

	$tpl = new tpl();
	$tpl->read("design/templates/editor/viewEdit.tpl");
	$tpl->set("file", $fil);
	$tpl->set("content", $this->getText());
	$tpl->show($sec);
}

// ***********************************************************
// execute changes
// ***********************************************************
private function save() {
	$txt = $this->getSave(); if (! $txt) return;
	return APP::write($this->dst, trim($txt));
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function setFile($fil) {
	$this->fil = FSO::clearRoot($fil);
	$this->src = FSO::join(APP_FBK, $this->fil);
	$this->dst = FSO::join(APP_DIR, $this->fil);
	$this->cur = APP::file($this->fil);
}

private function getText() {
	$txt = file_get_contents($this->cur);
	$txt = str_replace("<!MOD:", "&lt;!MOD:", $txt);
	return $txt;
}

private function getSave() {
	$txt = ENV::getPost("content"); if (! $txt) return false;
	$txt = str_replace("&lt;!MOD:", "<!MOD:", $txt);
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
