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
incCls("editor/iniDef.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniWriter extends iniDef {
	protected $tpl; // ini template - including sections for all ini types
	protected $edt = array(); // ini sections

function __construct($tplfile) {
	parent::__construct($tplfile);
}

// ***********************************************************
// handling sections
// ***********************************************************
public function addSec($sec) {
	$this->sec[$sec] = "# created by iniWriter";
}

public function clearSec($sec) {
	$vls = $this->getValues($sec);

	foreach ($vls as $key => $val) {
		unset ($this->vls[$key]);
	}
}

// ***********************************************************
// modifying properties
// ***********************************************************
public function savePost() {
	$this->setProps(OID::getLast());
	$this->save();
}

public function setProps($arr) {
	foreach ($arr as $sec => $vls) {
		if (! is_array($vls)) continue;
		self::setVals($vls, $sec);
	}
}

public function setVals($arr, $sec = "props") {
	if (STR::ends($sec, "*")) { // memo section
		$this->setSec($sec, $arr["tarea"]);
		return;
	}
	foreach ($arr as $key => $val) {
		$this->set("$sec.$key", $val);
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

	$val = STR::replace($val, "<dqot>", '"');
	return $val;
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function save($ful = NV) {
	if ($ful == NV) $ful = $this->file; $out = "";
	$this->chkUID();

	foreach ($this->sec as $sec => $txt) {
		$out.= "[$sec]\n";

		if (STR::ends($sec, "*")) { // memo sections
			$out.= "$txt\n";
		}
		else { // key = val sections
			$arr = $this->getValues($sec); if (! $arr) continue;

			foreach ($arr as $key => $val) {
				$key = STR::clear($key, "$sec.");
				$val = $this->secure($val);
				$val = $this->chkValue($val, $sec);

				$out.= "$key = $val\n";
			}
		}
		$out.= "\n";
	}
	return APP::write($ful, $out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
