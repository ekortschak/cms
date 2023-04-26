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
$ini->save($inifile);
$ini->read($inifile);
$ini->show();
*/

incCls("editor/iniWriter.php");
incCls("editor/iniEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniMgr extends iniDef {

function __construct($tplfile) {
	parent::__construct($tplfile);

	$this->register(NV, $tplfile);
}

// ***********************************************************
// display input fields by sections
// ***********************************************************
public function show() {
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
// rewriting content
// ***********************************************************
public function save($ful) {
	$ini = new iniWriter($ful);
	$ini->savePost();
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
