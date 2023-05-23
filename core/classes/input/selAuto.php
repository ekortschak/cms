<?php
/* ***********************************************************
// INFO
// ***********************************************************
creates input fields based on data format and field names
* e.g. props, title ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/selAuto.php");

$edi = new selAuto();
$edi->addInput($prop, $vals, $val);
$edi->show();
*/

incCls("editor/iniWriter.php");
incCls("input/selector.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selAuto extends selector {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// adding selector items
// ***********************************************************
public function addField($fname, $vals, $val) {
	if ($fname == "props[uid]") {
		if (PFS::isStatic())
		return $this->addObj("ronly", $fname, $vals, $val);
	}

	if (STR::contains($fname, "[tarea]")) {
		return $this->addObj("memo", $fname, $vals, $val);
	}

	if (is_array($vals)) {
		return $this->addObj("combo", $fname, $vals, $val);
	}
	if (STR::contains($fname, "_LANG")) {
		$arr = LNG::get();
		return $this->addObj("combo", $fname, $arr, $val);
	}
	if ($vals == "rating") {
		$val = intval($val);
		return $this->addObj("image", $fname, $val, "rating.png");
	}
	if ($vals == "colors") {
		return $this->addObj("color", $fname, $val);
	}
	if (STR::begins($vals, "range:")) {
		$val = intval($val);
		$min = STR::between($vals, ":", "-");
		$max = STR::after($vals, "-");
		return $this->addObj("range", $fname, $val, $min, $max);
	}

	if (STR::begins($vals, "folders:")) {
		$arr = $this->getFolders($vals);
		return $this->addObj("combo", $fname, $arr, $val);
	}
	if (STR::begins($vals, "files:")) {
		$arr = $this->getFiles($vals);
		return $this->addObj("combo", $fname, $arr, $val);
	}
	if (STR::begins($vals, "inifile:")) {
		$arr = $this->iniFiles($vals);
		return $this->addObj("combo", $fname, $arr, $val);
	}

	if ($vals == "0|1") {
		return $this->addObj("check", $fname, $val);
	}
	if ($vals == "1|0") {
		return $this->addObj("check", $fname, $val);
	}

	if (STR::contains($vals, "|")) { // standard combos
		$arr = STR::toAssoc($vals);
		return $this->addObj("combo", $fname, $arr, $val);
	}

	return $this->addObj("input", $fname, $val);
}

// ***********************************************************
protected function addObj($typ, $qid, $prm1, $prm2 = "", $prm3 = "") {
	$cap = STR::afterX($qid, "@"); if (STR::contains($qid, "["))
	$cap = STR::between($qid, "[", "]");
	$cap = DIC::get($cap);

	$this->$typ($qid, $prm1, $prm2, $prm3);
	$this->setProp("title", $cap);
	return true;
}

// ***********************************************************
// additional input
// ***********************************************************
public function memo($caption, $value = "", $rows = 4) { // text area colspan 100%
	$this->itm->inpMemo("tar", $caption, $value);
	$this->itm->set("rows", $rows);
}

// ***********************************************************
// handling arrays
// ***********************************************************
protected function getFolders($dir) {
	$dir = STR::after($dir, ":"); if (! $dir) return array();
	return APP::folders($dir);
}
protected function getFiles($dir) {
	$dir = STR::after($dir, ":"); if (! $dir) return array();
	return APP::files($dir);
}
protected function iniFiles($dir) {
	$dir = STR::after($dir, ":"); if (! $dir) return array();
	$arr = APP::files($dir);
	$out = array();

	foreach ($arr as $fil => $nam) {
		$key = STR::clear($nam, ".ini");
		$out[$key] = $key;
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
