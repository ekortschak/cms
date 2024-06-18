<?php
/* ***********************************************************
// INFO
// ***********************************************************
designed to handle tree views based on arbitrary arrays

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/tview.php");

$obj = new tview();
$idx = $obj->setData($arr);
$obj->set($idx, $prop, $value);
$obj->show();

*/

incCls("other/items.php");

CFG::set("MULTI_VAL", "[...]");
CFG::set("EMPTY_VAL", "[]");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tview extends items {

function __construct() {}

// ***********************************************************
// handling items
// ***********************************************************
public function setData($arr, $lev = 1, $pfx = "") {
	if (! is_array($arr)) return;

	foreach ($arr as $key => $val) {
		$idx = FSO::join($pfx, $key);

		$this->add($idx);
		$this->setHead($idx, $key);
		$this->set($idx, "level", $lev);
		$this->set($idx, "value", $val);

		if (is_array($val)) {
			$inf = MULTI_VAL; if (count($val) < 1)
			$inf = EMPTY_VAL;

			$this->set($idx, "value", $inf);
			$this->setData($val, $lev + 1, $idx);
		}
	}
	return $idx;
}

public function getData() {
	return $this->items();
}

// ***********************************************************
// displaying content
// ***********************************************************
public function show() {
	$tpl = new tpl();
	$tpl->load("menus/tview.tpl");
	$tpl->set("pfx", uniqid());

	$arr = $this->getData();
	$trg = array_key_first($arr);
	$trg = $this->find($trg);

	foreach ($arr as $idx => $inf) {
		$tit = $inf->get("head");  $tpl->set("title", $tit);
		$val = $inf->get("value"); $tpl->set("value", $val);
		$lev = $inf->get("level"); $tpl->set("level", $lev + 1);

		$sec = "value"; if ($val === MULTI_VAL)
		$sec = "folder";

		$tpl->set("index", $cnt++."");
		$tpl->set("vis", $this->isVisible($trg, $idx, $lev)); // expandable
		$tpl->set("pos", $this->isOpen($trg, $idx, $lev));

		$out.= $tpl->getSection($sec)."\n";
    }
    $tpl->set("items", $out);
    $tpl->show();
}

// ***********************************************************
// determine display features
// ***********************************************************
private function isVisible($dir, $index, $lev) {
	if ($lev < 2) return "block";
	if ($lev > 3) return "none"; // exclude deep level subdirs

	if (STR::begins($index, $dir)) return "block"; // show immediate subdirs
	if (STR::begins($dir, dirname($index))) return "block"; // show parents and siblings
	return "none";
}

private function isOpen($dir, $index, $lev) {
	if (STR::begins($dir, $index)) return "bottom";
	return "top";
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function setHead($idx, $key) {
	if ($key == strtoupper($key)) $key = "\\$key";
	$this->set($idx, "head", $key);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
