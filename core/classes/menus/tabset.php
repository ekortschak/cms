<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to associate tabs with tabsets

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/tabset.php");

$tbs = new tabset();
$arr = $tbs->getTabs($set);
$
*/

incCls("files/iniTab.php");
incCls("files/code.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabset extends iniTab {
	private $cfg = "config/tabsets.ini";
	private $tabs = array();

function __construct() {
	$this->read($this->cfg);
}

// ***********************************************************
// methods concerning sets
// ***********************************************************
public function validSets() {
	$lst = APP::files(APP_DIR, "php");
	$out = array();

	foreach ($lst as $val => $nam) {
		if (  STR::begins($nam, "x."))     continue;
		if (! STR::contains($nam, ".php")) continue;
		$out[$val] = $nam;
	}
	return $out;
}

public function getDefault($fil = APP_IDX) {
	$set = $this->find($fil); // see also KONST::fixStdTab()
	$lst = $this->getValues($set);
	$arr = array_flip($lst);

	$tab = $arr["default"]; if ($tab) return $tab;
	return current($arr);
}

// ***********************************************************
// methods concerning tabs
// ***********************************************************
public function getProps($set = NV) {
	return $this->getValues($set);
}

public function getTabs($set = APP_IDX, $all = false) {
	$set = $this->find($set);
	$arr = $this->getProps($set); $out = array();

	foreach ($arr as $tab => $usage) {
		if (! $all) if (! (bool) $usage) continue;

		$itm = new iniTab($tab);
		$tit = $itm->getTitle(); if (! $tit) continue;
		$out[$tab] = $tit;
	}
	return $out;
}

public function visTabs($set = NV) {
	$arr = $this->getProps($set); $out = array();

	foreach ($arr as $key => $val) {
		if ($val) $out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function norm($set) {
	if ($set == NV) $set = APP_IDX;
	return basename($set);
}

private function find($set) {
	if (! $set) $set = APP_IDX; $set = basename($set);
	if (STR::begins($set, "x.")) $set = "index.php";

	if ($this->isSec($set)) return $set;
	return "index.php";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
