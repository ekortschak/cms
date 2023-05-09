<?php
/* ***********************************************************
// INFO
// ***********************************************************
simple ini editor

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/iniMgr.php");

$obj = new iniMgr($tplfile);
$fil = $ini->getFile($dir, $caption);
$ext = $ini->getScope();
$xxx = $ini->show($fil);
*/

incCls("editor/iniWriter.php");
incCls("editor/iniEdit.php");
incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniMgr extends iniDef {

function __construct($tplfile) {
	parent::__construct($tplfile);

	$this->register(NV, $tplfile);
}

// ***********************************************************
// show selector
// ***********************************************************
public function getFile($dir, $caption, $selected = false) {
	$box = new dropBox("menu");
	$rel = $box->files($dir, $caption, $selected);
	$xxx = $box->show($rel);
	return $rel;
}

public function getScope($host = true) {
	$arr = array();
	$arr["ini"] = "Localhost"; if ($host)
	$arr["srv"] = "Server";

	$box = new dropBox("menu");
	$ext = $box->getKey("scope", $arr);
	$box->show();

	return $ext;
}

public function show($file = NV) {
	if ($file == NV) $rel = $this->file;
	else {
		$rel = APP::relPath($file);
		$this->save($rel);
	}
	$ful = APP::file($rel);
	$ful = STR::replace($ful, APP_FBK, "<red>CMS</red>");
	HTW::tag("file = $ful", "hint");

	if ($file != NV) $this->read($rel);
	$this->showForm();
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function save($ful) {
	$ini = new iniWriter($ful);
	$ini->savePost();
}

// ***********************************************************
// display input fields by sections
// ***********************************************************
private function showForm() {
	$sel = new iniEdit(); $lgs = LANGUAGES;
	$sel->register($this->oid);
	$sel->forget();

	foreach ($this->sec as $sec => $txt) {
		if (STR::begins($sec, "dic")) continue;

		$inf = "[$sec]"; if (STR::contains(".$lgs.", ".$sec."))
		$inf = HTM::flag($sec);
		$sel->section($inf);

		$typ = $this->getSecType($sec);

		if ($typ == "tarea") { // memo sections
			$val = $this->getSec($sec);
			$sel->addInput($sec."[tarea]", $val, 15);
		}
		else { // key = value sections
			$arr = $this->getValues($sec);

			foreach ($arr as $key => $val) {
				if (! $this->isKey("$sec.$key")) continue;

				$qid = $sec."[$key]";
				$vls = $this->getChoice("$sec.$key");
				$val = $this->chkValue($val, $sec);

				$sel->addInput($qid, $vls, $val);
			}
		}
	}
	$sel->show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function prepare() {
	$uid = $this->getUID();
	$tit = $this->getTitle();
	$hed = $this->getHead(); if ($tit == $hed) $hed = "";

	$this->set("UID",   $uid);
	$this->set("TITLE", $tit);
	$this->set("HEAD",  $hed);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
