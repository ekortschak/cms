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

$ini = new iniWriter($tplfile); // read defaults and file
$ini->read($inifile)
$ini->set($prop, $value);
$ini->save();
*/

incCls("other/uids.php");
incCls("files/ini.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniWriter extends ini {
	protected $lst = array(); // dropdown values for editor

function __construct($tplfile = false) {
	$tpl = $this->chkTpl($tplfile);	if (! $tpl) return;

	$this->read($tpl); $this->lst = $this->vls;
	$this->seal();
}

// ***********************************************************
// handling sections and keys
// ***********************************************************
public function addSec($sec) {
	$this->sec[$sec] = "";
}

public function dropSec($sec) {
	unset($this->sec[$sec]);
}

public function clearSec($sec) {
	$vls = $this->getValues($sec);

	foreach ($vls as $key => $val) {
		unset ($this->vls[$key]);
	}
}

public function fldType($sec, $default = "input") {
	return VEC::get($this->typ, $sec, $default);
}

// ***********************************************************
// handling items
// ***********************************************************
public function getChoice($key) {
	$val = VEC::get($this->lst, $key);
	if ($val == "NODE_TYPES") return $this->validTypes();
	return $val;
}

public function isKey($key) {
	return VEC::isKey($this->lst, $key);
}

// ***********************************************************
// modifying properties
// ***********************************************************
public function setProps($arr) {
	if (! is_array($arr)) return;

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

public function replace($sec, $arr) {
	$this->drop($sec); if (! $arr) return;

	$chk = VEC::get($this->sec, $sec);
	if (! $chk) $this->sec[$sec] = "";

	foreach ($arr as $key => $val) {
		$this->set("$sec.$key", $val);
	}
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function savePost($file = NV) {
	$arr = OID::getLast(); if (! $arr) return;

	$this->setProps($arr);
	$this->save($file);
}

// ***********************************************************
public function save($file = NV) {
	if ($file === NV) $file = $this->file; $out = "";
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
	return APP::write($file, $out);
}

// ***********************************************************
// methods for proper navigation
// ***********************************************************
public function setPage($uid = NV) {
	if ($uid === NV) $uid = $this->getUID();
	ENV::setPage($uid);
}

public function verifyUID() {
	$ids = new uids(); // make sure UID is unique
	$uid = $this->getUID();
	$chk = $this->getUID($uid); if ($uid == $chk) return;

	$this->set("props.uid", $chk);
	$this->save();
}

// ***********************************************************
protected function secure($val) {
	$val = STR::replace($val, "\#", "#");
	$val = STR::replace($val, "#", "\#");

	$val = STR::replace($val, "<dqot>", '"');
	return $val;
}

// ***********************************************************
// methods concerning templates
// ***********************************************************
private function chkTpl($fil) {
	if (strlen($fil) == 3) {
		$tpl = $this->isTemplate("page.$fil.def"); if ($tpl) return $tpl;
		return $this->isTemplate("page.def");
	}
	if (STR::ends($fil, "page.ini")) {
		$typ = $this->getType();
		$tpl = $this->isTemplate("page.$typ.def"); if ($tpl) return $tpl;
	}
	$tpl = basename($fil);
	$tpl = STR::replace($tpl, ".ini", ".def");
	$tpl = $this->isTemplate($tpl); if ($tpl) return $tpl;

#	$tpl = basename(dirname($fil));
#	$tpl = $this->isTemplate("$tpl.def"); if ($tpl) return $tpl;

	return false;
}

private function isTemplate($fil) {
	$tpl = FSO::join(LOC_CFG, $fil);
	return APP::file($tpl);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
