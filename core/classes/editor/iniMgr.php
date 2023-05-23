<?php
/* ***********************************************************
// INFO
// ***********************************************************
simple ini editor

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/iniMgr.php");

$mgr = new iniMgr($tplfile);
$mgr->read(inifile);
$mgr->setFile($dir, $caption);
$mgr->setScope();
$mgr->edit();
*/

incCls("editor/iniWriter.php");
incCls("editor/iniEdit.php");
incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniMgr extends objects {
	private $file = false;
	private $tpl = false;

function __construct($tplfile = false) {
	$this->tpl = $tplfile;
}

public function read($file) {
	$this->file = $file;
}

// ***********************************************************
// show banner
// ***********************************************************
public function setFile($dir, $caption, $selected = false) {
	$box = new dropBox("menu");
	$rel = $box->files($dir, $caption, $selected);
	$xxx = $box->show($rel);
	$this->read($rel);
}

public function setScope($host = true) {
	$arr = array();
	$arr["ini"] = "Localhost"; if ($host)
	$arr["srv"] = "Server";

	$box = new dropBox("menu");
	$ext = $box->getKey("scope", $arr);
	$box->show();

	$fil = STR::replace($this->file, ".ini", ".$ext");
	$this->read($fil);
}

// ***********************************************************
// show form
// ***********************************************************
public function edit() {
	$fil = $this->file; if (! $fil) return;
	$tpl = $this->tpl;

	$this->showPath($fil);

	$edi = new iniEdit($tpl);
	$edi->read($fil);
	$edi->edit();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function showPath($fil) {
	$ful = $fil; if ( ! STR::ends($fil, ".ini"))
	$ful = FSO::join($fil, "page.ini");
	$ful = APP::file($ful);
	$ful = STR::replace($ful, APP_FBK, "<red>CMS</red>");

	HTW::tag("file = $ful", "hint");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
