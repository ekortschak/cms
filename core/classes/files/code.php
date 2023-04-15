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
	protected $tps = array(); // section types
	protected $vrs = array(); // variables
	protected $hst = array(); // file history

function __construct() {}

// ***********************************************************
// read file(s)
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
	$fil = $this->isKnown($file);   if (! $fil) return false;
	$txt = $this->getContent($fil); if (! $txt) return false;
	$txt = $this->buttons($txt);

	$this->incFiles($txt);
	$this->regFiles($txt);
	$this->sections($txt);

	$this->addDics();
	$this->setVars();
	$this->setProps($file);

	return true;
}

// ***********************************************************
protected function getContent($file) {
	$txt = APP::read($file); if (! $txt) return "";
	$txt = STR::dropComments($txt);
	$txt = STR::dropSpaces($txt);
	return STR::replace($txt, "\#", "#");
}

// ***********************************************************
// retrieving info
// ***********************************************************
public function getVars() { return $this->vrs; }
public function getHist() { return $this->hst; }

public function getSecs($const = true) {
	if (! $const) return $this->sec; $out = array();

	foreach ($this->sec as $key => $val) {
		$out[$key] = CFG::insert($val);
	}
	return $out;
}

public function getTypes() {
	return $this->tps;
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

		$lng = STR::after($sec, "."); if (! $lng) $lng = "xx";
		$arr = $this->split($txt);

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
		$typ = "input";

		if (STR::ends($key, "*")) {
			$key = STR::before($key, "*");
			$typ = "tarea";
		}
		$this->sec[$key] = $val;
		$this->tps[$key] = $typ;
	}
	unset($this->sec["include"]);
	unset($this->sec["register"]);
}

protected function setVars() { // set vars
	$txt = VEC::get($this->sec, "vars"); if (! $txt) return;
	$arr = $this->split($txt);

	foreach ($arr as $key => $val) {
		$val = CFG::insert($val);
		$val = DIC::xlate($val);
		$this->vrs[$key] = $val;
	}
	unset($this->sec["vars"]);
}

protected function setProps($file) {
	$ext = FSO::ext($file); if ($ext == "tpl") return;

	foreach ($this->sec as $sec => $txt) {
		$arr = $this->split($txt);

		foreach ($arr as $key => $val) {
			$val = DIC::xlate($val);
			$this->set("$sec.$key", $val);
		}
	}
}

// ***********************************************************
// splitting sections
// ***********************************************************
protected function split($txt, $pfx = "\n", $lfd = "\n", $del = "=") {
	$arr = $txt; if (! is_array($txt))
	$arr = explode($lfd, $pfx.$txt); $out = array();

    foreach ($arr as $itm) {
		$key = STR::before($itm, $del); if (! $key) continue;
		$val = STR::after($itm, $del);
        $out[$key] = $val;
    }
    return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function isKnown($fil) {
	if ($fil == "fallback") { // shortcut in templates
		$fil = array_key_last($this->hst);
		$fil = APP::relPath($fil);
		$ful = FSO::join(APP_FBK, $fil);
	}
	else {
		$ful = APP::file($fil);
	}
	if (isset($this->hst[$ful])) return false;
	$val = intval(is_file($ful));

	$this->hst[$ful] = $val; if ($val) return $ful;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
