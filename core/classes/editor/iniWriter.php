<?php
/* ***********************************************************
// INFO
// ***********************************************************
needed to write changes to page.ini files
case sensitivity applies to keys

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/iniWriter.php");

$obj = new iniWriter($tplfile); // read defaults
$obj->read($inifile);           // overwrite defaults
$obj->set($prop, $value);
$obj->save();
*/

incCls("files/ini.php");
incCls("editor/iniTpl.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniWriter extends iniTpl {
	protected $tpl; // ini template - including sections for all ini types
	protected $edt = array(); // ini sections

function __construct($tplfile = NV) {
	parent::__construct($tplfile);
	$this->sealed = is_file($tplfile);
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function save($ful = NV) {
	if ($ful == NV) $ful = $this->file; $out = "";
	$this->chkUID();

	foreach ($this->sec as $sec => $txt) {
		$arr = $this->getValues($sec); if (! $arr) continue;
		$out.= "[$sec]\n";

		foreach ($arr as $key => $val) {
			$key = STR::clear($key, "$sec.");
			$val = $this->secure($val);
			$val = $this->chkValue($val, $sec);
			$out.= "$key = $val\n";
		}
		$out.= "\n";
	}
	return APP::write($ful, $out);
}

// ***********************************************************
// modifying properties
// ***********************************************************
public function getPost($pfx = "val_") {
	foreach ($_POST as $sec => $vls) {
		if (! STR::begins($sec, $pfx)) continue;
		$sec = STR::afterX($sec, $pfx);

		foreach ($vls as $key => $val) {
			$this->set("$sec.$key", $val);
		}
	}
}

public function setProps($arr) {
	foreach ($arr as $sec => $vls) {
		foreach ($vls as $key => $val) {
			$this->set("$sec.$key", $val);
		}
	}
}

public function setVals($arr, $sec = "props") {
	foreach ($arr as $key => $val) {
		$this->set("$sec.$key", $val);
	}
}

public function clearSec($sec) {
	$vls = $this->getValues($sec);

	foreach ($vls as $key => $val) {
		unset ($this->vls[$key]);
	}
}

// ***********************************************************
// adding properties
// ***********************************************************
public function replace($sec, $arr) {
	$this->drop($sec); if (! $arr) return;

	$chk = VEC::get($this->sec, $sec);
	if (! $chk) $this->sec[$sec] = "";

	foreach ($arr as $key => $val) {
		$this->set("$sec.$key", $val);
	}
}

// ***********************************************************
// securing and restoring values
// ***********************************************************
protected function secure($val) {
	$val = STR::replace($val, "\#", "#");
	$val = STR::replace($val, "#", "\#");
	return $val;
}

// ***********************************************************
// debugging
// ***********************************************************
public function dump() {
	DBG::vector($this->vls);
	die();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
