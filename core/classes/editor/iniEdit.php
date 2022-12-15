<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create lists for input objects for ini Files
* e.g. props, title ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/iniEdit.php");

$obj = new iniEdit();
$obj->show();
*/

incCls("input/selector.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniEdit extends selector {

function __construct() {
	parent::__construct();
	$this->forget($this->oid);
}

// ***********************************************************
// adding selector items
// ***********************************************************
public function addInput($fname, $vals, $val) {
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
private function addObj($typ, $qid, $prm1, $prm2 = "", $prm3 = "") {
	$cap = $qid;
	if (STR::contains($qid, "@")) $cap = STR::afterX($qid, "@");
	if (STR::contains($qid, "[")) $cap = STR::between($qid, "[", "]");

	$cap = DIC::get($cap);

	switch ($typ) {
		case "memo":  $obj = $this->$typ($qid, $prm1, $prm2); return;
		case "range": $obj = $this->$typ($qid, $prm1, $prm2, $prm3); break;
		case "ronly": $obj = $this->$typ($qid, $prm2, $prm2); break;
		default:      $obj = $this->$typ($qid, $prm1, $prm2);
	}
	$xxx = $this->setProp("title", $cap);
	return true;
}

// ***********************************************************
// additional input
// ***********************************************************
public function memo($caption, $value = "", $rows = 4) { // text area colspan 100%
	$out = $this->itm->inpMemo("tar", $caption, $value);
	$xxx = $this->itm->set("rows", $rows);
	return $out;
}

// ***********************************************************
// handling arrays
// ***********************************************************
private function getFolders($dir) {
	$dir = STR::after($dir, ":"); if (! $dir) return array();
	return APP::folders($dir);
}
private function getFiles($dir) {
	$dir = STR::after($dir, ":"); if (! $dir) return array();
	return APP::files($dir); $lst = array();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
