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

	KONST::set("TOP_PATH", $tpc);
	KONST::set("TAB_ROOT", APP::dir($tab.DIR_SEP));
	KONST::set("TAB_PATH", APP::dir($tpc.DIR_SEP));
	KONST::set("CUR_TAB",  FSO::clearRoot($tpc));
	KONST::set("TAB_TYPE", $typ);

	ENV::set("tab.$idx", $tab);
	ENV::set("tpc.$tab", $tpc);
	ENV::set("pge.$tpc", $pge);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getTab() {
	$tab = ENV::getParm("tpc"); if ($tab) {
		$arr = explode(DIR_SEP, $tab); if (count($arr) > 2) array_pop($arr);
		return implode(DIR_SEP, $arr);;
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

	if ($typ != "select")
	return $tab;
	return FSO::join($tab, self::$tpc);
}

// ***********************************************************
private static function getPage($tab) {
	$pge = VEC::get($_GET, "pge"); if ($pge) return $pge;
	$pge = ENV::get("pge.$tab");   if ($pge) return $pge;

	$ini = new ini("$tab/tab.ini");
	return $ini->get("props.std");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
