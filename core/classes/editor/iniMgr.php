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
$ini->read($fil);
$ini->save($fil);
$ini->show();
*/

incCls("editor/iniWriter.php");
incCls("editor/iniEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniMgr extends iniTpl {


function __construct($tplfile) {
	parent::__construct($tplfile);

	$this->setSealed(is_file($tplfile));
}

// ***********************************************************
// display input fields by sections
// ***********************************************************
public function show() {
	$sel = new iniEdit(); $lgs = LANGUAGES;

	foreach ($this->sec as $sec => $txt) {
		if (STR::begins($sec, "dic")) continue;
		if (STR::contains(".$lgs.", ".$sec."))
		$sel->section("<img src='core/icons/flags/$sec.gif' class='flag' />"); else
		$sel->section("[$sec]");

		foreach ($this->vls as $key => $val) {
			if (! STR::begins($key, "$sec.")) continue;

			$qid = STR::replace($key, "$sec.", $sec."[")."]";
			$vls = $this->getChoice($key, $sec);
			$val = $this->chkValue($val, $sec);

			$sel->addInput($qid, $vls, $val);
		}
	}
	$sel->show();
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function save($ful = NV) {
	if ($ful == NV) $ful = $this->file; $out = "";

	$arr = ENV::getPostGrps("val_"); if (! $arr) return;

	$ini = new iniWriter($ful);
	$ini->getPost();
	$ini->save();
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
