<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to associate tabs with tabsetss

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/tabsets.php");

$tbs = new tabsets();
$arr = $tbs->items($set);

*/

incCls("files/iniTab.php");
incCls("files/code.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabsets extends iniTab {

function __construct() {
	$this->read("config/tabsets.ini");
}

// ***********************************************************
// methods
// ***********************************************************
public function items($set = TAB_SET) {
	$arr = $this->getValues($set); $out = array();

	foreach ($arr as $tab => $usage) {
		if (STR::contains($usage, "local"))
		if (! IS_LOCAL) continue;

		$itm = new iniTab($tab);
		$tit = $itm->getTitle(); if (! $tit) continue;

		$out[$tab] = $tit;
	}
	return $out;
}

// ***********************************************************
// query properties
// ***********************************************************
public function isVisible($set, $tab) {
	$prp = $this->prop($set, $tab); if (! $prp) return false;
	return STR::misses($prp, "0");
}
public function isLocal($set, $tab) {
	$prp = $this->prop($set, $tab); if (! $prp) return false;
	return STR::contains($prp, "local");
}
public function isDefault($set, $tab) {
	$prp = $this->prop($set, $tab); if (! $prp) return false;
	return STR::contains($prp, "default");
}

// ***********************************************************
private function prop($set, $tab) {
	$arr = $this->getValues($set); if (! $arr) return false;
	return strtolower(VEC::get($arr, $tab));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
