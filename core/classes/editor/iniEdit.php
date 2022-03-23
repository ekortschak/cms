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
	private $prp = array();

function __construct() {
	parent::__construct();
	$this->read("design/templates/editor/iniEdit.tpl");
}

// ***********************************************************
// props section
// ***********************************************************
public function uniq($val = false) {
	if (! $val) $val = uniqid();
	return $this->input("Unique ID", $val);
}

// ***********************************************************
public function tabtype($caption = "Type", $sel = "root") {
	$arr = array(
		"root"   => "single topic",
		"select" => "multiple topics"
	);
	return $this->combo($caption, $arr, $sel);
}

// ***********************************************************
// adding selector items
// ***********************************************************
public function addByDefault($fname, $vals, $val) {
	if ($fname == "props[uid]") {
		if (PFS::isStatic())
		return $this->addObj("ronly", $fname, $vals, $val);
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
	if (STR::contains($vals, "|")) { // standard combos
		$arr = STR::toAssoc($vals);
		return $this->addObj("combo", $fname, $arr, $val);
	}
	return $this->addObj("input", $fname, $val);
}

private function addObj($typ, $qid, $prm1, $prm2 = "") {
	$cap = $qid;
	if (STR::contains($qid, "@")) $cap = STR::afterX($qid, "@");
	if (STR::contains($qid, "[")) $cap = STR::between($qid, "[", "]");

	$cap = DIC::get($cap);

	switch ($typ) {
		case "ronly": $obj = $this->$typ($qid, $prm2, $prm2); break;
		default:      $obj = $this->$typ($qid, $prm1, $prm2);
	}
	$xxx = $this->setProp("title", $cap);
	return true;
}

// ***********************************************************
// handling arrays
// ***********************************************************
private function getFolders($dir) {
	$dir = STR::afterX($dir, ":");
	$arr = APP::folders($dir);
	$arr = array_values($arr);
	return array_combine($arr, $arr);
}
private function getFiles($dir) {
	$dir = STR::after($dir, ":");
	$arr = APP::files($dir); $lst = array();

	foreach ($arr as $itm) {
		$itm = STR::before($itm, ".");
		$lst[$itm] = $itm;
	}
	return $lst;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
