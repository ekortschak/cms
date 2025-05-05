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
	$tpl = $this->chkTpl($tplfile); if (! $tpl) return;

	$this->read($tpl);
	$this->lst = $this->vls;
	$this->sealed = true;
}

// ***********************************************************
// handling sections and keys
// ***********************************************************
public function addSec($sec) {
	if (isset($this->sec[$sec])) return;
	$this->sec[$sec] = "";
}

public function dropSec($sec) {
	$this->clearSec($sec);
	unset($this->sec[$sec]);
}

public function clearSec($sec) {
	$vls = $this->values($sec);

	foreach ($vls as $key => $val) {
		unset ($this->vls["$sec.$key"]);
	}
}

public function fldType($sec, $default = "input") {
	return VEC::get($this->typ, $sec, $default);
}

public function sort($sec = "props") {
	if ( ! $this->isSec($sec)) return;
	$arr = $this->values($sec);
	$xxx = $this->clearSec($sec);

	foreach ($arr as $key => $val) {
		$this->set("$sec.$key", $val);
	}
}

// ***********************************************************
// handling items
// ***********************************************************
public function getChoice($key) {
	$val = VEC::get($this->lst, $key);
	if ($val == "NODE_TYPES") return $this->validTypes();
	return $val;
}

public function dropKey($key) {
	$this->vls = VEC::dropKey($this->vls, $key);
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

public function setNoprint($val) {
	$this->set("props.noprint", $val);
}

public function setPbreak($val) {
	$this->set(CUR_LANG.".pbreak", $val);
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function savePost($file = NV) {
	$arr = OID::values(); if (! $arr) return;
	$this->setProps($arr);
	$this->save($file);
}

// ***********************************************************
public function save($file = NV) {
	if ($file === NV) $file = $this->file; $out = "";

	foreach ($this->sec as $sec => $txt) {
		$out.= "[$sec]\n";

		if (STR::ends($sec, "*")) { // memo sections
			$out.= "$txt\n";
		}
		else { // key = val sections
			$arr = $this->values($sec); if (! $arr) continue;

			foreach ($arr as $key => $val) {
				$key = STR::clear($key, "$sec.");
				$val = $this->secure($val);
				$val = $this->chkValue($val, $sec);

				$out.= "$key = $val\n";
			}
		}
		$out.= "\n";
	}
	if (is_dir($file)) $file = FSO::join($file, "page.ini");
	return APP::write($file, $out);
}

// ***********************************************************
// methods for proper navigation
// ***********************************************************
public function checkIni() {
	$uid = $this->getUID();
	$lgs = LNG::get();

	$this->set("props.uid", $uid);

	foreach ($lgs as $lng) {
		$this->addSec($lng);

		$tit = $this->title($lng); if (! $tit) $tit = $uid;
		$hed = $this->head($lng);  if ($tit == $hed) $hed = "";

		$this->set("$lng.title", $tit);
		$this->set("$lng.head", $hed);
	}
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
	if (! $fil) return false;
	if (strlen($fil) == 3) { // define by type
		$tpl = $this->getTpl("page.$fil.def"); if ($tpl) return $tpl;
		return $this->getTpl("page.def");
	}
	if (STR::ends($fil, "page.ini")) { // defien by props.typ
		$typ = $this->getType();
		$tpl = $this->getTpl("page.$typ.def"); if ($tpl) return $tpl;
		return $this->getTpl("page.def");
	}
	$tpl = basename($fil); // define by file name
	$tpl = STR::replace($tpl, ".ini", ".def");
	$tpl = $this->getTpl($tpl); if ($tpl) return $tpl;
	return false;
}

private function getTpl($fil) {
	$tpl = FSO::join(LOC_CFG, $fil);
	return APP::file($tpl);
}

// ***********************************************************
// debugging
// ***********************************************************
public function debug() {
	DBG::text($this->vls);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
