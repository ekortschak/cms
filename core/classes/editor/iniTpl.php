<?php
/* ***********************************************************
// INFO
// ***********************************************************
simple ini editor

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/iniTpl.php");

$obj = new iniTpl($tplfile);
$obj->show($inifile);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniTpl extends ini {
	protected $lst = array();

function __construct($tpl) {
	parent::__construct($tpl);

	$this->lst = $this->vls;

	$this->chkLang();
	$this->chkVals();
}

// ***********************************************************
// handling sections
// ***********************************************************
public function addSec($sec) {
	$this->sec[$sec] = array();
}

// ***********************************************************
// handling items
// ***********************************************************
public function setChoice($prop, $values, $key = NV) {
	$vls = array(); if ($key != NV) $vls[$key] = NV;

	foreach ($values as $key => $val) {
		$vls[$key] = $val;
	}
	$this->lst[$prop] = $vls;
}

public function getList($key) {
	return VEC::get($this->lst, $key);
}

public function getProp($what = "title") {
	switch ($what) {
		case "UID":   $out = parent::getUID(); if ($out != "UID") return $out;
		case "title": $out = parent::getTitle(); break;
		case "head":  $out = parent::getHead();  break;
		default: return "";
	}
	$out = $this->getName();

	if ($what == "UID") return $out;
	return ucfirst($out);
}

protected function checkUID() {
	$uid = $this->get("props.uid"); if (! $uid) return;
	$uid = STR::replace($uid, "&", "_");
	$uid = STR::replace($uid, "?", "_");
	$this->set("props.uid", $uid);
}

// ***********************************************************
// handling values
// ***********************************************************
private function chkLang() {
	$pfx = "curlang";
	$arr = $this->getValues($pfx); if (! $arr) return;
	$lgs = LNG::get();

	foreach ($arr as $key => $val) {
		foreach ($lgs as $lng) {
			$qid = "$lng.$key";
			$this->lst[$qid] = $val;
			$this->vls[$qid] = $this->chkValue($val);
		}
		unset($this->vls["$pfx.$key"]);
	}
	foreach ($lgs as $lng) {
		$this->sec[$lng] = $lng;
	}
	unset($this->sec[$pfx]);
}

private function chkVals() {
	foreach ($this->vls as $key => $val) {
		$this->vls[$key] = $this->chkValue($val);
	}
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkValue($val) {
	return STR::before($val, "|");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
