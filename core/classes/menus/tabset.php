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
// methods concerning tabs
// ***********************************************************
public function getProps($set = NV) {
	return $this->getValues($set);
}

public function getTabs($set = APP_CALL, $all = false) {
	$arr = $this->getProps($set); $out = array();

	foreach ($arr as $tab => $usage) {
		if (STR::contains($usage, "local")) $usage = IS_LOCAL;
		if (! $all) if (! (bool) $usage) continue;

		$itm = new iniTab($tab);
		$tit = $itm->getTitle(); if (! $tit) continue;
		$out[$tab] = $tit;
	}
	return $out;
}

public function visTabs($set = APP_CALL) {
	$arr = $this->getProps($set); $out = array();

	foreach ($arr as $key => $val) {
		if ($val) $out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
