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

function __construct($tplfile) {
	parent::__construct($tplfile);

	$this->chkLang();
	$this->lst = $this->vls;

	$this->setSealed(is_file($tplfile));
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
// checking values
// ***********************************************************
protected function secure($val) {
	$val = STR::replace($val, "<?php", "&lt;?php");
	return parent::secure($val);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
