<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for handling templates, ini files, dics ...
i.e. files with sections and vars

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/code.php");

$code = new code();
$txt = $code->read($file);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class code extends objects {
	protected $sec = array(); // sections
	protected $vrs = array(); // variables
	protected $hst = array(); // file history
	protected $bad = array(); // file history

function __construct() {}

// ***********************************************************
// special formats
// ***********************************************************
public function readPath($dir, $fil = "perms.ini") {
	$dir = APP::dir($dir); if (! $dir) return;
	$arr = FSO::parents($dir);

	foreach ($arr as $dir) {
		$ptn = FSO::join($dir, $fil);
		$this->read($ptn);
	}
}

public function read($file) { // ini lines
	$fil = $this->checkFile($file); if (! $fil) return;
	$txt = $this->getContent($fil); if (! $txt) return;
	$txt = $this->buttons($txt);

	$this->incFiles($txt);
	$this->regFiles($txt);
	$this->sections($txt);

	$this->addDics();
	$this->setVars();
	$this->setProps($file);
}

// ***********************************************************
protected function getContent($file) {
	$txt = APP::read($file); if (! $txt) return array();
	$txt = STR::dropComments($txt);
	$txt = STR::dropSpaces($txt);
	return STR::replace($txt, "\#", "#");
}

// ***********************************************************
// retrieving info
// ***********************************************************
public function getVars() { return $this->vrs; }
public function getHist() { return $this->hst; }
public function getBad()  { return $this->bad; }

public function getSecs() {
	$out = array();

	foreach ($this->sec as $key => $val) {
		$out[$key] = CFG::insert($val);
	}
	return $out;
}

public function getProp($prop, $default = "") {
	$out = $this->get("props.$prop.".CUR_LANG); if ($out) return $out;
	$out = $this->get("props.$prop.".GEN_LANG); if ($out) return $out;
	$out = $this->get("props.$prop.xx"); if ($out) return $out;
	$out = $this->get("props.$prop"); if ($out) return $out;
	return $default;
}

public function getInfo($sec = "info", $default = "") { // tailored for tooltips
	$chk = ENV::get("opt.tooltip");	if (! $chk) return;

	$out = VEC::get($this->sec, $sec.".".CUR_LANG); if ($out) return $out;
	$out = VEC::get($this->sec, $sec.".".GEN_LANG); if ($out) return $out;
	$out = VEC::get($this->sec, $sec.".xx"); if ($out) return $out;
	$out = VEC::get($this->sec, $sec); if ($out) return $out;
	return $default;
}

// ***********************************************************
// preparing ENV
// ***********************************************************
protected function incFiles($txt) {
	$inc = STR::between($txt, "[include]", "[");

	if (! $inc) return;
	$arr = VEC::explode($inc, "\n");

	foreach ($arr as $fil) {
		$this->read($fil);
	}
}

protected function regFiles($txt) { // register scripts
	$reg = STR::between($txt, "[register]", "["); if (! $reg) return;
	$arr = VEC::explode($reg, "\n");

	foreach ($arr as $fil) {
		$ext = FSO::ext($fil);
		$xxx = REG::add($ext, $fil);
	}
}

protected function addDics() { // register dic entries
	foreach ($this->sec as $sec => $txt) {
		if ( ! STR::begins($sec, "dic")) continue;
		$lng = STR::after($sec, ".");
		$arr = $this->getItems($txt);

		DIC::append($arr, $lng);
		unset($this->sec[$sec]);
	}
}

// ***********************************************************
// shortcuts
// ***********************************************************
protected function buttons($txt) {
	$arr = STR::find($txt, "<!BTN:", "!>"); if (! $arr) return $txt;
	incCls("input/button.php");

	foreach ($arr as $itm) {
		$btn = new button();
		$xxx = $btn->read($itm);
		$rep = $btn->gc($itm);
		$txt = STR::replace($txt, "<!BTN:$itm!>", $rep);
	}
	return $txt;
}

// ***********************************************************
// fill arrays
// ***********************************************************
protected function sections($txt) {
	$arr = STR::find("\n".$txt, "\n[", "]");

	foreach ($arr as $sec) {
		$key = STR::norm($sec, true);
		$val = STR::between($txt, "[$sec]", "\n[");
		$this->sec[$key] = $val;
	}
	unset($this->sec["include"]);
	unset($this->sec["register"]);
}

protected function setVars() { // set vars
	$txt = VEC::get($this->sec, "vars"); if (! $txt) return;
	$this->vrs = $this->getItems($txt);
	unset($this->sec["vars"]);
}

protected function setProps($file) {
	$ext = FSO::ext($file); if ($ext == "tpl") return;

	foreach ($this->sec as $sec => $txt) {
		$arr = $this->getItems($txt);

		foreach ($arr as $key => $val) {
			$val = DIC::xlate($val);
			$this->set("$sec.$key", $val);
		}
	}
}

// ***********************************************************
// splitting sections
// ***********************************************************
protected function getItems($txt, $pfx = "\n", $lfd = "\n", $del = "=") {
	$arr = $txt; if (! is_array($txt))
	$arr = explode($lfd, $pfx.$txt); $out = array();

    foreach ($arr as $itm) {
		$key = STR::before($itm, $del); if (! $key) continue;
		$val = STR::after($itm, $del);
		$val = CFG::insert($val);
        $out[$key] = $val;
    }
    return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function checkFile($fil) {
	if ($fil == "fallback") { // shortcut in templates
		$fil = end($this->hst);
		$ful = FSO::join(APP_FBK, $fil);
	}
	else {
		$fil = CFG::insert($fil);
		$ful = APP::file($fil);
	}
	if (isset($this->hst[$ful])) return false;

	switch (is_file($ful)) {
		case true: $this->hst[$ful] = $ful; return $ful;
		default:   $this->bad[$ful] = $ful; break;
	}
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
