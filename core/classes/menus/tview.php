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
$obj->readTree();
$obj->setData($arr);
$obj->show();

*/

incCls("other/items.php");

CFG::set("MULTI_VAL", "[...]");
CFG::set("EMPTY_VAL", "[]");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tview extends objects {
	private $itm; // menu items & props

function __construct() {
	$this->itm = new items();
	$this->register();
}

// ***********************************************************
// handling items
// ***********************************************************
public function setData($arr, $lev = 1, $pfx = "") {
	if (! is_array($arr)) return;

	foreach ($arr as $key => $val) {
		$idx = FSO::join($pfx, $key);

		$this->itm->addItem($idx);
		$this->setProp($idx, "head",  $key);
		$this->setProp($idx, "level", $lev);
		$this->setProp($idx, "value", $val);

		if (is_array($val)) {
			$inf = MULTI_VAL; if (count($val) < 1)
			$inf = EMPTY_VAL;

			$this->setProp($idx, "value", $inf);
			$this->setData($val, $lev + 1, $idx);
		}
	}
}

public function getData() {
	return $this->itm->getItems();
}

// ***********************************************************
public function count() {
	return $this->itm->count();
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProp($index, $key, $value) {
	$this->itm->setProp($index, $key, $value);
}
private function getProp($index, $key, $default = false) {
	return $this->itm->getProp($index, $key, $default);
}

// ***********************************************************
// displaying content
// ***********************************************************
public function show() {
	$tpl = new tpl();
	$tpl->load("menus/tview.tpl");
	$tpl->set("pfx", uniqid());

	$arr = $this->getData(); $out = "";
	$lst = $this->count();   $cnt = 0;

	$trg = array_key_first($arr);
	$trg = $this->find($trg);

	foreach ($arr as $idx => $inf) {
		$tit = $inf["head"];      $tpl->set("title", $tit);
		$val = $inf["value"];     $tpl->set("value", $val);
		$lev = $inf["level"] + 1; $tpl->set("level", $lev);

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
private function find($default) {
	return OID::get($this->oid, "trg", $default);
}

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
} // END OF CLASS
// ***********************************************************
?>
