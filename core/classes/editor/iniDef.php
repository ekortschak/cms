<?php
/* ***********************************************************
// INFO
// ***********************************************************
simple ini editor

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/iniDef.php");

$obj = new iniDef($tplfile);
$obj->show($inifile);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniDef extends ini {
	protected $lst = array(); // dropdown values for editor

function __construct($tplfile) {
	parent::__construct($tplfile);

	$this->setSealed($tplfile);
	$this->chkLang();

	$this->lst = $this->vls;
}

// ***********************************************************
// handling sections
// ***********************************************************
public function addSec($sec) {
	$this->sec[$sec] = array();
}

// ***********************************************************
// handling sealed ini files
// ***********************************************************
private function setSealed($fso) {
	$isf = APP::file($fso);
	$def = STR::ends($fso, ".def");

	$this->sealed = ($isf && $def);
}

public function isKey($key) {
	return VEC::isKey($this->lst, $key);
}

// ***********************************************************
// handling items
// ***********************************************************
public function setChoice($key, $values, $selected = NV) {
	$vls = array(); if ($selected !== NV) $vls[$selected] = NV;

	foreach ($values as $item => $val) {
		$vls[$item] = $val;
	}
	$this->lst[$key] = $vls;
}

public function getChoice($key) {
	$val = VEC::get($this->lst, $key);
	if ($val == "NODE_TYPES") return $this->validTypes();
	return $val;
}

// ***********************************************************
// checking languages
// ***********************************************************
private function chkLang() {
	$pfx = "curlang";
	$arr = $this->getValues($pfx); if (! $arr) return;
	$lgs = LNG::get();

	foreach ($lgs as $lng) {
		foreach ($arr as $key => $val) {
			$this->vls["$lng.$key"] = $val;
			unset($this->vls["$pfx.$key"]);
		}
		$this->sec[$lng] = $lng;
	}
	unset($this->sec[$pfx]);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
