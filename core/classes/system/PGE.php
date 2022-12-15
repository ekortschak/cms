<?php
/* ***********************************************************
// INFO
// ***********************************************************
page related functionality

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PGE {
	private static $tpc = "";

public static function init() {
	$idx = APP_IDX;
	$tab = self::getTab();
	$typ = self::getType($tab);
	$tpc = self::getTopic($tab, $typ);
	$pge = self::getPage($tpc);

	if ($typ != "select") {
		$tab = $tpc;
	}
	CFG::set("TAB_HOME", $tpc);
	CFG::set("TAB_ROOT", APP::dir($tab.DIR_SEP));
	CFG::set("TAB_PATH", APP::dir($tpc.DIR_SEP));
	CFG::set("TAB_TYPE", $typ);
	CFG::set("CUR_TAB",  APP::relPath($tpc));

	ENV::set("tab.$idx", $tab);
	ENV::set("tpc.$tab", $tpc);
	ENV::set("pge.$tpc", $pge);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getTab() {
	$tpc = ENV::getParm("tpc"); if ($tpc) {
		return dirname($tpc);
	}
	$tab = ENV::getParm("tab");      if ($tab) return $tab;
	$tab = ENV::get("tab.".APP_IDX); if ($tab) return $tab;
	$set = basename(APP_IDX);

	$ini = new ini("config/tabsets.ini");
	$arr = $ini->getValues($set);
	$lst = array_flip($arr);

	$tab = VEC::get($lst, "default"); if ($tab) return $tab;
	return key($arr);
}

// ***********************************************************
private static function getType($tab) {
	$ini = new ini("$tab/tab.ini");
	$typ = $ini->get("props.typ");
	$std = $ini->get("props.std");

	if ($typ == "select") self::$tpc = basename($std);
	return $typ;
}

// ***********************************************************
private static function getTopic($tab, $typ) {
	$tpc = ENV::getParm("tpc");  if ($tpc) return $tpc;
	$tpc = ENV::get("tpc.$tab"); if ($tpc) return $tpc;

	if ($typ != "select") return $tab;
	return FSO::join($tab, self::$tpc);
}

// ***********************************************************
private static function getPage($tab) {
	$pge = ENV::getParm("pge");  if ($pge) return $pge;
	$pge = ENV::get("pge.$tab"); if ($pge) return $pge;

	$ini = new ini("$tab/tab.ini");
	$pge = $ini->get("props.std");
	return $pge;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
