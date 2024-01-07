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
$arr = $tbs->getTabs($set);

*/

incCls("files/iniTab.php");
incCls("files/code.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabsets extends iniTab {
	private $tabs = array();

function __construct() {
	$this->read("config/tabsets.ini");
}

// ***********************************************************
// methods
// ***********************************************************
public function getProps($set = NV) {
	return $this->getValues($set);
}

public function getTabs($set = TAB_SET) {
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

public function visTabs($set = TAB_SET) {
	$arr = $this->getValues($set); $out = array();

	foreach ($arr as $key => $val) {
		if ($val) $out[$key] = $val;
	}
	return $out;
}

public function verify($set, $tab) {
	$arr = $this->visTabs($set);
	$cap = VEC::get($arr, $tab, NV); if ($cap === NV)
	$tab = array_key_first($arr);
	return $tab;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
