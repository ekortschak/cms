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
$ini->exec($inifile);
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

		if (STR::ends($sec, "*")) { // memo sections
			$val = $this->getSec($sec);
			$sel->addInput($sec."[tarea]", $val, 15);
		}
		else { // key = value sections
			$arr = $this->getValues($sec);

			foreach ($arr as $key => $val) {
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
public function exec($ful) {
	$this->save($ful); $this->forget();
	$this->read($ful);
}

private function save($ful = NV) {
	$arr = OID::getLast(); if (! $arr) return;

	if ($ful == NV) $ful = $this->file;

	$ini = new iniWriter($ful);
	$ini->setPost($arr);
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
